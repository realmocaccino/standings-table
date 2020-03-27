document.addEventListener('DOMContentLoaded', () => {
    input = document.querySelector('#result-insert-input')

    document.querySelectorAll('.playerName').forEach(element => {
        element.addEventListener('click', ev => {
            input.value = input.value + element.innerHTML + (!input.value ? ' ' : '')
            input.focus()
        });
    });

    document.querySelector('#result-search-input').addEventListener('keyup', ev => {
        document.querySelectorAll('#results table tr').forEach(tr => {
            tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(ev.target.value.toUpperCase())) ? '' : 'none'
        })
    })
    
    input.addEventListener('keyup', ev => {
        backspaceKeyCode = 8
        
        if(ev.keyCode != backspaceKeyCode) {
            ev.target.value = ev.target.value.replace(/^(.*) ([0-3])$/, '$1 $2-').replace(/^(.*) ([0-3]-[0-3])$/, '$1 $2 ')
        }
    });
});