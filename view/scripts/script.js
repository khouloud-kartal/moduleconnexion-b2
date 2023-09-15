//////////////////////////////////// Delete ///////////////////////////////////////


const deleteBtn = document.querySelectorAll('.delete');

for (const Btn of deleteBtn) {
    Btn.addEventListener('click', async(e)=>{
        e.preventDefault();

        const response = await fetch('admin.php?delete=' + Btn.id);
        
        Btn.parentNode.parentNode.parentNode.removeChild(Btn.parentNode.parentNode);
        
    })
}



////////////////////////////////////// Display Error /////////////////////////////////


const form = document.querySelector('form');

const displayError = async ($id) =>{ 
    const formData = new FormData(form);
    const response = await fetch($id + '.php?inscription=true', {method: "POST", body: formData});
    const responseData = await response.text();
    console.log(responseData);

    if(responseData === 'Vous êtes connecté(e), vous allez être rédiger dans la page d\'acceuil dans 2 secondes.'){
        setTimeout(() => {
            window.location.href = "http://localhost/github/moduleconnexion-b2/view/index.php";
        }, 2000);
    }

    const message = document.getElementById('message');

    message.innerHTML = responseData;
}

form.addEventListener('submit', async(e) =>{
    e.preventDefault();
    await displayError(form.id);
});


