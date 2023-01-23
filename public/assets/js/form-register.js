export default {
    'title': 'Register',
    inputs: [
        {
            'name': 'm',
            'type': 'hidden',
            'value': 'register',
        },
        {
            'name': 'email',
            'type': 'email',
            'label': 'Email',
            'placeholder': 'Email',
            'required': true,
        },
        {
            'name': 'username',
            'type': 'text',
            'label': 'Username',
            'placeholder': 'Username',
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

