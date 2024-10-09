const navE1 = document.querySelector('.nav');
const hamburgerE1 = document.querySelector('.hamburger');

hamburgerE1.addEventListener('click', () => {
  navE1.classList.toggle("nav--open");
  hamburgerE1.classList.toggle("hamburger--open");
});

navE1.addEventListener('click', () => {
    navE1.classList.remove("nav--open");
    hamburgerE1.classList.remove("hamburger--open");
});

// Array of image sources
const images = [
  '../media/banner.png',
  '../media/banner2.png',
  '../media/banner3.png'
];

// Index to keep track of the current image
let currentIndex = 0;

// Function to change the image source
function changeImage(index) {
  const imgElement = document.getElementById('slideshow');
  currentIndex = (index + images.length) % images.length;
  imgElement.src = images[currentIndex];

  // Add the fade-in class
  imgElement.classList.remove('show');
  imgElement.classList.add('fade-in');

  // Change the image source after a short delay to allow the fade-out effect
  setTimeout(() => {
      imgElement.src = images[currentIndex];
      imgElement.classList.add('show');
  }, 100); // Adjust the delay as needed
}

// Function to show the next image
function nextImage() {
  console.log('Next image clicked');
  changeImage(currentIndex + 1);
}

// Function to show the previous image
function prevImage() {
  console.log('Previous image clicked');
  changeImage(currentIndex - 1);
}

// Change image every 15 seconds (15000 milliseconds)
setInterval(nextImage, 15000);