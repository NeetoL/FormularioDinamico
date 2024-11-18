 function updateDateTime() {
    const now = new Date();
    const date = now.toLocaleDateString('pt-BR');
    const time = now.toLocaleTimeString('pt-BR');
    document.querySelector('#currentDateTime .date').textContent = date;
    document.querySelector('#currentDateTime .time').textContent = time;
}

setInterval(updateDateTime, 1000);

function updateData() {
    const formCount = 10;
    document.getElementById('formCount').textContent = formCount;

    const userCount = 200;
    document.getElementById('userCount').textContent = userCount;

    const newMessages = 5;
    document.getElementById('newMessages').textContent = newMessages;
}

updateData();