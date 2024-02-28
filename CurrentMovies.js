function filterCards() {
  const searchBox = document.getElementById("searchBox");
  const filterSelect = document.getElementById("filterSelect");
  const cardRow = document.getElementById("cardRow");
  const cards = cardRow.getElementsByClassName("col-md-3");
  for (let i = 0; i < cards.length; i++) {
    const card = cards[i];
    const title = card.getElementsByClassName("card-title")[0];
    const category = card.getElementsByClassName("card-text")[0];
    const searchKeyword = searchBox.value.toLowerCase();
    const filterKeyword = filterSelect.value.toLowerCase();
    const titleText = title.textContent.toLowerCase();
    const categoryText = category.textContent.toLowerCase();
    if (
      titleText.includes(searchKeyword) &&
      (filterKeyword === "" || categoryText.includes(filterKeyword))
    ) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  }
}