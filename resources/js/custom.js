const axios = require('axios').default;

$("body").on('click', '#delete-bookmark', function(){
    let id = $(this).data('id');
    axios.post('/bookmark/' + id, {
        _method: 'DELETE'
    })
    .then(function (response){
        window.location.reload();
    })
    .catch(function (error){
        console.log(error);
    });
});