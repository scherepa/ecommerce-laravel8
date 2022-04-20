window.addEventListener('swal',function(e){
    var id = e.detail.id;
    delete e.detail.id;
    Swal.fire(e.detail).then((result) => {
        if (result.isConfirmed) {
            window.livewire.emit('destroy', id)
         }
         else{
            return false;
        }
    }); 
});