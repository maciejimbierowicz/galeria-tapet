let categoryButton = document.querySelector('.category-button');


document.addEventListener("click", function (e) {
    if (e.target.classList.contains("gallery-item")) {
        const src = e.target.getAttribute("src");
        console.log(src);
    }
})


function showModal() {
  document.querySelector('.modal').modal('toggle');
}


// DELETE CONFIRMATION

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

