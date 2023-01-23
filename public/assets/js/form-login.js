let process_response = function (json) {
    console.log('process_response', json);
    // check if user api key is set
    if (json.user_api_key) {
        // store in local storage
        localStorage.setItem('user_api_key', json.user_api_key);
    }
}

export default {
    'title': 'Login',
    process_response,
    inputs: [
        {
            'name': 'm',
            'type': 'hidden',
            'value': 'login',
        },
        {
            'name': 'email',
            'type': 'email',
            'label': 'Email',
            'placeholder': 'Email',
            'required': true,
        },
        {
            'name': 'password',
            'type': 'password',
            'label': 'Password',
            'placeholder': 'Password',
            'required': true,
        },
    ],
}

