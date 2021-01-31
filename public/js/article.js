window.addEventListener('load', () => {
    let articleName = '';
    let articleContent = '';
    let articleAuthor = '';
    let articleId = '';
    
    fetch('/api/articles', {
            method: "GET"
        }).then(response => response.text()
        ).then(data => {
            let tableBody = '';
            const articles = JSON.parse(data);
            if (articles.length === 0) {
                tableBody = '<tr class=no-rows><td colspan="5"> Brak wyników </td></tr>';
            } else {
                articles.forEach((article, key) => {
                    tableBody = tableBody + `<tr class='active-row'>
                        <td id='article_name${article['id']}'>${article['article_name']}</td>
                        <td class='article-table-content' id='article-content${article['id']}'>${article['content']}</td>
                        <td id='author-name${article['id']}'>${article['author']}</td>
                        <td id='add-date${article['id']}'>${article['created_at']}</td>
                        <td>${article['updated_at']}</td>
                        <td>
                            <input type=button class='edit-button' id="edit-button${article['id']}" name="editArticle" value="Edytuj" data-bind="${article['id']}"/> 
                            <input type=button class="delete-button" name="deleteArticle" data-bind="${article['id']}" value="Usuń"/>
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
            articleId = target.dataset.bind;
            articleName = document.querySelector(`#article_name${articleId} `).textContent;
            articleContent = document.querySelector(`#article-content${articleId}`).textContent;
            articleAuthor = document.querySelector(`#author-name${articleId}`).textContent;

            document.querySelector('.article-id').value = articleId;
            document.querySelector('.article-name').value = articleName;
            document.querySelector('.article-content').value = articleContent;
            document.querySelector('.save-or-edit').value = 'edit';
            getAuthorsForArticle();

            document.querySelector('#article-action-modal').style.display = 'flex';
        }

        if (target.className.match('delete-button')) {
            fetch("/api/delete/article", {
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
        document.querySelector('#article-action-modal').style.display = 'none';
    });
 let authors;
            let selectOption = '';
            fetch('/api/authors', {
                method: "GET"
            }).then(response => response.text()
            ).then(data => {
                authors = JSON.parse(data);
                authors.forEach((author, key) => {
                    if (author['author'] === articleAuthor) {
                        selectOption = selectOption + `<option value=${author['ID']} selected='selected'>${author['author']}</option>`;    
                    } else {
                        selectOption = selectOption + `<option value=${author['ID']}>${author['author']}</option>`;    
                    }
                });

                document.querySelector('.article-author').innerHTML = `<select name="article-author">${selectOption}</select>`;
            });

    document.querySelector('#save-modal').addEventListener("click", () => {
        if (document.querySelector('.article-name').value === '' || document.querySelector('.article-content' === '')) {
            alert('Uzupełnij wszystkie pola');
        } else {
            const formData = ($('#modal-form').serializeArray());
            let url = "api/update/article";
            let text = 'Artykuł edytowany prawidłowo';

            if (document.querySelector('.save-or-edit').value === 'save') {
                url = "api/add/article";
                text = "Artykuł dodany prawidłowo";
            }

            $.ajax({
                type: "POST",
                url: url,
                data: JSON.stringify(formData),
                dataType: 'application/json',
                success: $('#article-action-modal').css('display', 'none')
            });

            $('.message').text(text);
        }
    });

    document.querySelector('#add-article').addEventListener('click', () => {
        document.querySelector('.save-or-edit').value = 'save';
        document.querySelector('.article-id').value = '';
        document.querySelector('.article-name').value = '';
        document.querySelector('.article-content').value = '';
        getAuthorsForArticle();
        document.querySelector('#article-action-modal').style.display = 'flex';
    });

    function getAuthorsForArticle() {
        let authors;
        let selectOption = '';
        fetch('/api/authors', {
            method: "GET"
        }).then(response => response.text()
        ).then(data => {
            authors = JSON.parse(data);
            authors.forEach((author, key) => {
                if ((author['name'] + ' ' + author['surname']) === articleAuthor) {
                    selectOption = selectOption + `<option value=${author['ID']} selected='selected'>${author['name']} ${author['surname']}</option>`;    
                } else {
                    selectOption = selectOption + `<option value=${author['ID']}>${author['name']} ${author['surname']}</option>`;    
                }
            });

            document.querySelector('.article-author').innerHTML = `<select name="article-author">${selectOption}</select>`;
        });
    }

});