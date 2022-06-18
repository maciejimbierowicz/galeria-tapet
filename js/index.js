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


  let deleteLinks = document.querySelectorAll('.delete-button');

  for (var i = 0; i < deleteLinks.length; i++) {
    deleteLinks[i].addEventListener('click', function(event) {
        event.preventDefault();
  
        var choice = confirm(this.getAttribute('data-confirm'));
  
        if (choice) {
          window.location.href = this.getAttribute('href');
        }
    });
  }


  let adminButtons = document.querySelectorAll('.admin-menu a');
function addActiveClass(e) {
    let elems = document.querySelectorAll(".active-class");
    [].forEach.call(elems, function(el) {
      el.classList.remove("active-class");
    });
    e.target.className = "active-class";
  }

  

  adminButtons.addEventListener('click', addActiveClass)
  modalButton.addEventListener("click", showModal)