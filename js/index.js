let categoryButton = document.querySelector('.category-button');
let modalButton = document.querySelector('#modal-button')

document.addEventListener("click", function (e) {
    if (e.target.classList.contains("gallery-item")) {
        const src = e.target.getAttribute("src");
        console.log(src);
    }
})

function showModal(){
$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
  })}

  modalButton.addEventListener("click", showModal)