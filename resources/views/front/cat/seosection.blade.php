@php

  /** Seo of category pages */

    if($request->keyword){
        $title      = __('Showing all results for :keyword',['keyword' => $request->keyword]);
        $seodes     = $title;
    }
    else if($request->chid)
    {
        $findchid = App\Grandcategory::find($request->chid);
        $title    = __(':title - All products | ',['title' => $findchid->title]);
        $seodes   = strip_tags($findchid->description);
        $seoimage = url('images/grandcategory/'.$findchid->image);
    }
    else if($request->sid)
    {
        $findsubcat = App\Subcategory::find($request->sid);
        $title      = __(':title - All products | ',['title' => $findsubcat->title]);
        $seodes     = strip_tags($findsubcat->description);
        $seoimage   = url('images/subcategory/'.$findsubcat->image);

    }else{

        $findcat    = App\Category::find($request->catID);
        $title      = __(':title - All products | ',['title' => $findcat->title]);
        $seodes     = strip_tags($findcat->description);
        $seoimage   = url('images/category/'.$findcat->image);

    }

  /* End */

@endphp
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta property="og:title" content="{{ $title }}" />
<meta name="keywords" content="{{ $title }}">
<meta property="og:description" content="{{ $seodes }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->full() }}" />
<meta property="og:image" content="{{ isset($seoimage) ? $seoimage : '' }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:description" content="{{ $seodes }}" />
<meta name="twitter:site" content="{{ url()->full() }}" />
