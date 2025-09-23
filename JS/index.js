document.onscroll = function(){
if (window.pageYOffset <=10) {
    document.querySelector("#go-up").style.display="none";
}
else{
    document.querySelector("#go-up").style.display="block";
}}