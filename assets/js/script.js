function showConfirmation() {
  var confirmed = confirm("Подтвердите удаление");
  return confirmed;
}
// ======= CARD ACCORDION =======
const cards = document.querySelectorAll(".ql_card_content__desc");
console.log(cards);

cards.forEach((card) => {
  card.addEventListener("click", () => {
    card.classList.toggle("active");
  });
});

const textarea = document.querySelector(".create_post");
textarea.addEventListener("keyup", (e) => {
  let scHeight = e.target.scrollHeight;
  textarea.style.height = "auto";
  textarea.style.height = `${scHeight}px`;
});
