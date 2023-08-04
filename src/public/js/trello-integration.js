function renderBoardLists(selectedBoard, boards) {
    const listSelectContainer = document.getElementById("trello-list-container");
    if(selectedBoard !== "Select a board") {
        console.log(selectedBoard);
        const lists = boards.find((board) => board.id === selectedBoard)["lists"];
        let cardTitleContainer = document.getElementById("trello-card-title-container");

        console.log(lists);
        if (lists.length !== 0) {
            const listSelect = document.getElementById("trello-list-select");
            let selectOptions = `<option selected disabled>Select a list</option>`;
            lists.forEach((list) => {
                selectOptions += `<option value="${list.id}">${list.name}</option>`
            });

            listSelect.innerHTML = selectOptions;

            if (listSelectContainer.classList.contains("invisible")) {
                listSelectContainer.classList.remove("invisible");
                listSelectContainer.classList.remove("d-none");
            }
        }
        else
        {
            listSelectContainer.classList.add("invisible");
            listSelectContainer.classList.add("d-none");
            cardTitleContainer.classList.add("invisible");
            cardTitleContainer.classList.add("d-none");
        }
    }
}

function listSelectionChange() {
    let cardTitleContainer = document.getElementById("trello-card-title-container");

    if (cardTitleContainer.classList.contains("invisible")) {
        cardTitleContainer.classList.remove("invisible");
        cardTitleContainer.classList.remove("d-none");
    }
}

// These are Trello All List related JS functions

function createTrelloList(boardId, formToken) {
    const listTitle = document.getElementById("trello-create-list-input").value;

    const listCreateSpinner = document.getElementById("trello-create-list-loader");
    if (listCreateSpinner) {
        listCreateSpinner.classList.toggle("d-none");
        listCreateSpinner.classList.toggle("d-flex");
    }

    //@TODO - Fix list ordering

    if(listTitle !== '') {
        fetch(`/trello/list/${boardId}/create?formToken=${formToken}`,{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                title: `${listTitle}`
            })
        })
            .then((response) => response.json())
            .then((json) => {
                if (!json.error) {
                    const trelloListContainer =
                        document.getElementById(`trello-lists-container`);
                    const el =
                        document.getElementById(`trello-list-create`);

                    el.remove();

                    trelloListContainer.innerHTML += json.data;
                    trelloListContainer.append(el);
                    document.getElementById("trello-create-list-input").value = '';

                    if (listCreateSpinner) {
                        listCreateSpinner.classList.toggle("d-none");
                        listCreateSpinner.classList.toggle("d-flex");
                    }
                }
            });
    }

}

// These are Trello All card related JS functions

function createTrelloCardInput(listId) {
    document.getElementById(listId + "-create-trello-card-form")?.classList.toggle("invisible");
    document.getElementById(listId + "-create-trello-card-form")?.classList.toggle("d-none");
    document.getElementById(listId + "-create-trello-card-button")?.classList.toggle("invisible");
}

function cancelTrelloCardCreate(listId) {
    document.getElementById(listId + "-create-trello-card-form")?.classList.toggle("invisible");
    document.getElementById(listId + "-create-trello-card-form")?.classList.toggle("d-none");
    document.getElementById(listId + "-create-trello-card-button")?.classList.toggle("invisible");
    // document.getElementById(listId + "-create-trello-card-input")?.value = '';
}
function createTrelloCard(listId, formToken) {
    const trelloCreateCardForm = document.getElementById(listId + "-create-trello-card-form");
    if (trelloCreateCardForm) {
        trelloCreateCardForm.classList.toggle("invisible");
        trelloCreateCardForm.classList.toggle("d-none");
    }

    const trelloCardCreateLoader = document.getElementById(listId + "-create-trello-card-loader");
    if (trelloCardCreateLoader) {
        trelloCardCreateLoader.classList.toggle("d-none");
        trelloCardCreateLoader.classList.toggle("d-flex");
    }

    document.getElementById(listId + "-create-trello-card-button")?.classList.toggle("invisible");


    const listTitle = document.getElementById(listId + "-create-trello-card-input")?.value;


    fetch(`/trello/card/create?formToken=${formToken}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            "list": `${listId}`,
            "title": `${listTitle}`
        })
    })
        .then((response) => response.text())
        .then((data) => {
            document.getElementById(`trello-list-${listId}-items`).innerHTML += data;
            trelloCardCreateLoader.classList.toggle("d-flex");
            trelloCardCreateLoader.classList.toggle("d-none");
        });
}

function getCardDetails(cardId, formToken) {
    fetch(`/trello/card/${cardId}/details?formToken=${formToken}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        }
    })
        .then((response) => response.json())
        .then((json) => {
            if(!json.error) {
                document.getElementById('trello-message').innerHTML = json.data;
                const myModal = new bootstrap.Modal('#card-detail-modal', {
                    keyboard: false
                })

                if(myModal) {
                    myModal.show();
                }
            }
        });
}