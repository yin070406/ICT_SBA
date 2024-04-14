const searchInput = document.querySelector(".searchbar");

searchInput.addEventListener("keyup", function(event) {
  if(event.key === "Enter") {
    const searchtxt = searchInput.value;
    window.location.href = "/ICT_SBA/Game/" + searchtxt.toLowerCase() + ".html"; 
  }
});