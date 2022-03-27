
# V1 Update Employee Role Request

## Structure

`V1UpdateEmployeeRoleRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `body` | [`V1EmployeeRole`](/doc/models/v1-employee-role.md) | Required | V1EmployeeRole | getBody(): V1EmployeeRole | setBody(V1EmployeeRole body): void |

## Example (as JSON)

```json
{
  "body": {
    "id": "id6",
    "name": "name6",
    "permissions": [
      "REGISTER_APPLY_RESTRICTED_DISCOUNTS",
      "REGISTER_CHANGE_SETTINGS",
      "REGISTER_EDIT_ITEM"
    ],
    "is_owner": false,
    "created_at": "created_at4",
    "updated_at": "updated_at8"
  }
}
```

