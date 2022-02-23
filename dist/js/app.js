
function enableLoadSpinner(element = document.getElementById('articleArea')) {
    element.innerHTML +=
        '<div id="loadSpinner" class="d-flex justify-content-center h-50">\n' +
        '   <div class="spinner-border mt-auto"></div>\n' +
        '</div>'
}

const app = new Vue({
    el: '#app',
    router: appRouter,
    data: {

    }
})