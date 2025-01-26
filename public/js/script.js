document.addEventListener('DOMContentLoaded', () => {
  const flashMessage = document.querySelectorAll('.flash-message');
  flashMessage.forEach((message) => {
    message.classList.add('show');
  })
  setTimeout(() => {
    flashMessage.forEach((message) => {
      message.classList.add('hide');
      setTimeout(() => {
        message.style.display = 'none'
      }, 500);
    })
  }, 5000);
});