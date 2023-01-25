# forms

## register

```json
{
    "name": "register",
    "inputs": [
        {
            "name": "m",
            "type": "hidden",
            "value": "register"
        },
        {
            "name": "email",
            "label": "email",
            "type": "email",
            "value": ""
        },
        {
            "name": "username",
            "label": "username",
            "type": "text",
            "value": ""
        },
        {
            "name": "password",
            "label": "password",
            "type": "password",
            "value": ""
        }
    ]
}
```

## login

```json
{
    "name": "login",
    "inputs": [
        {
            "name": "m",
            "type": "hidden",
            "value": "login"
        },
        {
            "name": "email",
            "label": "email",
            "type": "email",
            "value": ""
        },
        {
            "name": "password",
            "label": "password",
            "type": "password",
            "value": ""
        }
    ]
}
```

### process_response

```js
// check if user api key is set
if (json.user_api_key) {
    // store in local storage
    localStorage.setItem('api_user_key', json.user_api_key);
    compo.center.login_ok = true;
    compo.center.api_user_key = json.user_api_key;
    console.log(compo.center);   
}
```