console.log('o-test.js loaded');

let inject = [ 'main_app' ];

let data_compo = {
};

let template = `
<div>
    <h1>o-test</h1>
</div>
`;

let methods = {

}

let created = function () {
    this.main_app.test('o-test created');
}

let mounted = function () {
    this.main_app.test('o-test mounted');
}

// vue js async component
export default {
    template,
    inject,
    data: () => data_compo,
    // mixins,
    // setup,
    methods,
    created,
    mounted,
}