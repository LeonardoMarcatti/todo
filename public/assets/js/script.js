const btns = document.querySelectorAll('.acao');
btns.forEach(btn => {
    btn.addEventListener('click', e => {
      const {value, id} = e.target;
      if (id === 'deletar') {
        document.querySelector('#delLink').setAttribute('href', `delete?id=${value}`);
      }

      if (id === 'concluir') {
        document.querySelector('#concluirLink').setAttribute('href', `concluir?id=${value}`);
      }

      if (id === 'editar') {
        setTimeout(() => {
          document.querySelector('#editForm').setAttribute('action', `editar?id=${value}`);
          const txt = e.target.closest('tr').children[0].innerText;
          document.querySelector('#editText').innerHTML = txt;
        }, 200);
      }
    });
});