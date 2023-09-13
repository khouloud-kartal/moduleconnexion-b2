const form = document.querySelector('form');

const displayError = async ($id) =>{ 
    const formData = new FormData(form);
    const response = await fetch($id + '.php?inscription=true', {method: "POST", body: formData});
    const responseData = await response.text();
    console.log(responseData);

    if(responseData === 'Vous êtes connecté(e)'){
        window.location.href = "http://localhost/github/moduleconnexion-b2/view/index.php";
    }

    const message = document.getElementById('message');

    message.innerHTML = responseData;
}


form.addEventListener('submit', async(e) =>{
    e.preventDefault();

    console.log(form.id);
    await displayError(form.id);
});
