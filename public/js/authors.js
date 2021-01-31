window.addEventListener('load', () => {
    let authorName = '';
    let authorSurname = '';
    let authorId = '';
    
    fetch('/api/authors', {
            method: "GET"
        }).then(response => response.text()
        ).then(data => {
            let tableBody = '';
            const author = JSON.parse(data);
            if (author.length === 0) {
                tableBody = '<tr class=no-rows><td colspan="5"> Brak wyników </td></tr>';
            } else {
                author.forEach((author, key) => {
                    tableBody = tableBody + `<tr class='active-row'>
                        <td id='author-name${author['ID']}'>${author['name']}</td>
                        <td class='author-content' id='author-surname${author['ID']}'>${author['surname']}</td>
                        <td id='add-date${author['ID']}'>${author['created_at']}</td>
                        <td>${author['updated_at']}</td>
                        <td>
                            <input type=button class='edit-button' id="edit-button${author['ID']}" name="editArticle" value="Edytuj" data-bind="${author['ID']}"/> 
                            <input type=button class="delete-button" name="deleteArticle" data-bind="${author['ID']}" value="Usuń"/>
                        </td>
                    </tr>`;
                });
            }  
        
            document.querySelector('#form-body').innerHTML = tableBody;
        });

    if (document.body.addEventListener) {
        document.body.addEventListener('click', articleAction, false);
    }

    function articleAction(event) {
        event = event || window.Event;
        let target = event.target || event.srcElement;

        if (target.className.match('edit-button')) {
            authorId = target.dataset.bind;
            authorName = document.querySelector(`#author-name${authorId}`).textContent;
            authorSurname = document.querySelector(`#author-surname${authorId}`).textContent;

            document.querySelector('.author-id').value = authorId;
            document.querySelector('.author-name').value = authorName;
            document.querySelector('.author-surname').value = authorSurname;
            document.querySelector('.save-or-edit').value = 'edit';
            document.querySelector('#author-action-modal').style.display = 'flex';
        }

        if (target.className.match('delete-button')) {
            fetch("/api/delete/author", {
                method: "POST",
                body: JSON.stringify({id: target.dataset.bind}),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                console.log("Request complete! response:", res.status);
                window.location.reload(true);
              });
        }
    }
    
    document.querySelector('#close-modal').addEventListener("click", () => {
        document.querySelector('#author-action-modal').style.display = 'none';
    });

    document.querySelector('#save-modal').addEventListener("click", () => {
        if (document.querySelector('.author-name').value === '' || document.querySelector('.author-surname' === '')) {
            alert('Uzupełnij wszystkie pola');
        } else {
            const formData = ($('#modal-form').serializeArray());
            let url = "api/update/author";
            let text = 'Autor edytowany prawidłowo';

            if (document.querySelector('.save-or-edit').value === 'save') {
                url = "api/add/author";
                text = "Autor dodany prawidłowo";
            }

            $.ajax({
                type: "POST",
                url: url,
                data: JSON.stringify(formData),
                dataType: 'application/json',
                success: $('#author-action-modal').css('display', 'none')
            });

            $('.message').text(text);
        }
    });

    document.querySelector('#add-author').addEventListener('click', () => {
        document.querySelector('.save-or-edit').value = 'save';
        document.querySelector('.author-id').value = '';
        document.querySelector('.author-name').value = '';
        document.querySelector('.author-surname').value = '';
        document.querySelector('#author-action-modal').style.display = 'flex';
    });
});