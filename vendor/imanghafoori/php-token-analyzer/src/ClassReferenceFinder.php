<?php

namespace Imanghafoori\TokenAnalyzer;

class ClassReferenceFinder
{
    private static $lastToken = [null, null, null];

    private static $secLastToken = [null, null, null];

    private static $token = [null, null, null];

    /**
     * @param  array  $tokens
     *
     * @return array
     */
    public static function process(&$tokens)
    {
        ! defined('T_NAME_QUALIFIED') && define('T_NAME_QUALIFIED', 3030);
        ! defined('T_NAME_FULLY_QUALIFIED') && define('T_NAME_FULLY_QUALIFIED', 3031);

        $namespace = '';
        $classes = [];
        $c = 0;
        $force_close = $implements = $collect = false;
        $trait = $isDefiningFunction = $isCatchException = $isSignature = $isDefiningMethod = $isInsideMethod = $isInSideClass = false;

        while (self::$token = current($tokens)) {
            next($tokens);
            $t = self::$token[0];

            if ($t === T_USE) {
                next($tokens);
                // use function Name\Space\function_name;
                if (current($tokens)[0] === T_FUNCTION) {
                    // we do not collect the namespaced function name
                    next($tokens);
                    $force_close = true;
                    self::forward();
                    continue;
                }

                // function () use ($var) {...}
                // for this type of use we do not care and continue;
                // who cares?!
                if (self::$lastToken === ')') {
                    self::forward();
                    continue;
                }

                // Since we don't want to collect use statements (imports)
                // and we want to collect the used traits on the class.
                if (! $isInSideClass) {
                    $force_close = true;
                    $collect = false;
                } else {
                    $trait = true;
                    $collect = true;
                }
                self::forward();
                continue;
            } elseif ($t === T_CLASS || $t === T_TRAIT) {
                // new class {... }
                // ::class
                if (self::$lastToken[0] === T_NEW || self::$lastToken[0] === T_DOUBLE_COLON) {
                    $collect = false;
                    self::forward();
                    continue;
                }
                $isInSideClass = true;
            } elseif ($t === T_CATCH) {
                $collect = true;
                $isCatchException = true;
                continue;
            } elseif ($t === T_NAMESPACE && ! $namespace && self::$lastToken[0] !== T_DOUBLE_COLON) {
                $collect = false;
                next($tokens);
                while (current($tokens)[0] !== ';') {
                    (! in_array(current($tokens)[0], [T_COMMENT, T_WHITESPACE])) && $namespace .= current($tokens)[1];
                    next($tokens);
                }
                next($tokens);
                continue;
            } elseif (\in_array($t, [T_PUBLIC, T_PROTECTED, T_PRIVATE], true)) {
                $isInsideMethod = false;
            } elseif ($t === T_FUNCTION) {
                $isDefiningFunction = true;
                if ($isInSideClass and ! $isInsideMethod) {
                    $isDefiningMethod = true;
                }
            } elseif ($t === T_VARIABLE || $t === T_ELLIPSIS) {
                //if ($isDefiningFunction) {
                //$c++;
                //}
                $collect = false;
                self::forward();
                // we do not want to collect variables
                continue;
            } elseif ($t === T_IMPLEMENTS) {
                $collect = $implements = true;
                isset($classes[$c]) && $c++;
                self::forward();
                continue;
            } elseif ($t === T_EXTENDS) {
                $collect = true;
                //isset($classes[$c]) && $c++;
                self::forward();
                continue;
            } elseif ($t === T_WHITESPACE || $t === '&' || $t === T_COMMENT) {
                // We do not want to keep track of
                // white spaces or collect them
                continue;
            } elseif (in_array($t, [';', '}', T_BOOLEAN_AND, T_BOOLEAN_OR, T_LOGICAL_OR, T_LOGICAL_AND], true)) {
                $trait = $force_close = false;

                // Interface methods end up with ";"
                $t === ';' && $isSignature = false;
                $collect && isset($classes[$c]) && $c++;
                $collect = false;

                self::forward();
                continue;
            } elseif ($t === ',') {
                // to avoid mistaking commas in default array values with commas between args
                // example:   function hello($arg = [1, 2]) { ... }
                $collect = ($isSignature && self::$lastToken[0] === T_VARIABLE) || $implements || $trait;
                $isInSideClass && ($force_close = false);
                // for method calls: foo(new Hello, $var);
                // we do not want to collect after comma.
                isset($classes[$c]) && $c++;
                self::forward();
                continue;
            } elseif ($t === ']') {
                $force_close = $collect = false;
                isset($classes[$c]) && $c++;
                self::forward();
                continue;
            } elseif ($t === '{') {
                if ($isDefiningMethod) {
                    $isInsideMethod = true;
                }
                $isDefiningMethod = $implements = $isSignature = false;
                // After "extends \Some\other\Class_v"
                // we need to switch to the next level.
                if ($collect) {
                    isset($classes[$c]) && $c++;
                    $collect = false;
                }
                self::forward();
                continue;
            } elseif ($t === '(' || $t === ')') {
                // wrong...
                if ($t === '(' && ($isDefiningFunction || $isCatchException)) {
                    $isSignature = true;
                    $collect = true;
                } else {
                    // so is calling a method by: ()
                    $collect = false;
                }
                if ($t === ')') {
                    $isCatchException = $isDefiningFunction = false;
                }
                isset($classes[$c]) && $c++;
                self::forward();
                continue;
            } elseif ($t === '?') {
                // for a syntax like this:
                // public function __construct(?Payment $payment) { ... }
                // we skip collecting
                self::forward();
                continue;
            } elseif ($t === T_DOUBLE_COLON) {
                // When we reach the ::class syntax.
                // we do not want to treat: $var::method(), self::method()
                // as a real class name, so it must be of type T_STRING
                if (! $collect && self::$lastToken[0] === T_STRING && ! \in_array(self::$lastToken[1], ['parent', 'self', 'static'], true) && (self::$secLastToken[1] ?? null) !== '->') {
                    $classes[$c][] = self::$lastToken;
                }
                $collect = false;
                isset($classes[$c]) && $c++;
                self::forward();
                continue;
            } elseif ($t === T_NS_SEPARATOR) {
                if (! $force_close) {
                    $collect = true;
                }

                // Add the previous token,
                // In case the namespace does not start with '\'
                // like: App\User::where(...
                if (self::$lastToken[0] === T_STRING && $collect && ! isset($classes[$c])) {
                    $classes[$c][] = self::$lastToken;
                }
            } elseif ($t === T_NAME_QUALIFIED || $t === T_NAME_FULLY_QUALIFIED) {
                if ($isInSideClass) {
                    $collect = true;
                }
                //self::forward();
            } elseif ($t === T_NEW) {
                // We start to collect tokens after the new keyword.
                // unless we reach a variable name.
                // currently tokenizer recognizes CONST NEW = 1; as new keyword.
                (self::$lastToken[0] != T_CONST) && $collect = true;
                self::forward();

                // we do not want to collect the new keyword itself
                continue;
            } elseif ($t === '|') {
                isset($classes[$c]) && $c++;
                self::forward();

                continue;
            } elseif ($t === ':') {
                if ($isSignature) {
                    $collect = true;
                } else {
                    $collect = false;
                    isset($classes[$c]) && $c++;
                }
                self::forward();
                continue;
            }

            if ($collect && ! self::isBuiltinType(self::$token)) {
                $classes[$c][] = self::$token;
            }
            self::forward();
        }

        return [$classes, $namespace];
    }

    protected static function forward()
    {
        self::$secLastToken = self::$lastToken;
        self::$lastToken = self::$token;
    }

    public static function isBuiltinType($token)
    {
        return \in_array($token[1], [
            'object',
            'string',
            'noreturn',
            'int',
            'private',
            'public',
            'protected',
            'float',
            'void',
            'false',
            'true',
            'null',
            'bool',
            'array',
            'mixed',
            'callable',
            '::',
            'iterable',
        ], true);
    }
}
