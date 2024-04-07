const buttonRadioAdmin = document.getElementById('roleAdmin');
const buttonRadioAgent = document.getElementById('roleAgent');
const buttonRadioTarget = document.getElementById('roleTarget');
const buttonRadioContact = document.getElementById('roleContact');
const buttonRadios = document.querySelectorAll('input[name="roleRadio"]');
const formRoleAdmin = document.getElementById('formAdmin');
const formNoAdmin = document.getElementById('formNoAdmin');
const formRoleAgent = document.getElementById('formAgent');
const adminAdd = document.getElementById('adminAdd');

for (const buttonRadio of buttonRadios){
    buttonRadio.addEventListener('click', ()=> {
        if (buttonRadioAdmin.checked){
            formRoleAdmin.classList.remove('d-none');
            formRoleAdmin.classList.add('d-block');
            if (!("d-none" in formNoAdmin.classList)){
                formNoAdmin.classList.remove('d-block');
                formNoAdmin.classList.add('d-none');
            }
            if (!("d-none" in formRoleAgent.classList)){
                formRoleAgent.classList.add('d-none');
            }
        } else {
            formNoAdmin.classList.remove('d-none');
            formNoAdmin.classList.add('d-block');
            if (!("d-none" in formRoleAdmin.classList)){
                formRoleAdmin.classList.add('d-none');
            }
            if (buttonRadioAgent.checked) {
                formRoleAgent.classList.remove('d-none');
                formRoleAgent.classList.add('d-block');
            } else {
                if (!("d-none" in formRoleAgent.classList)){
                    formRoleAgent.classList.add('d-none');
                } 
            }
        }
    })
}


