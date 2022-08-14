// создаем кнопку редактирования

function createEditButton() {
    let editButton = document.createElement('button');
    editButton.className = 'button edit-button';
    editButton.innerText = '✎';

    return editButton;
}

// для работы с заголовком

function createEditTitleButton() {
    let button = createEditButton();
    button.addEventListener('click', createTitleText);
    saveNotes();

    return button;
}

function createTitleText(event) {
    event.stopPropagation();
    let note = event.target.parentElement;
    replaceTitleWithInput(note);
}

// заменяем текущий заголовок заметки полем ввода

function replaceTitleWithInput(title) {
    let titleText = title.querySelector('.title-note-text');
    let styles = window.getComputedStyle(titleText);
    let rows = (titleText.getBoundingClientRect().height / parseInt(styles.lineHeight));
    let input = createTitleInput(titleText.innerText, rows);
    title.innerHTML = '';
    title.appendChild(input);
    input.focus();
}

// создаем новый текст заголовка

function createTitleInput(text, rows) {
    let input = createInput(text, rows);
    input.onblur = replaceInputWithTitle;

    return input;
}

function replaceInputWithTitle(event) {
    let input = event.target;
    replaceTitleWithInputText(input);
}

function createEditNewTitleText(text) {
    let titleText = document.createElement('span');
    titleText.classList.add('title-note-text');
    titleText.innerText = text.trim();

    return titleText;
}

function replaceTitleWithInputText(input) {
    let newText = input.value;
    let title = input.parentElement;
    if (newText.trim() === '') {
        title.closest('.note').remove(); //удаление доски при пустом заголовке
        }
    else {
        title.innerHTML = '';
        title.appendChild(createEditNewTitleText(newText));
        title.appendChild(createEditTitleButton());
    }
}

// для работы с задачами

//создаем поле ввода

function createInput(text, rows) {
    let input = document.createElement('textarea');
    input.value = text;
    input.rows = rows;
    input.classList.add('input');

    return input;
}

// добавляем кнопку удаления доски

let notes = document.querySelectorAll('.note');

for (let button of notes) {
    button.appendChild(createDelButton());
}

// добавляет новую заметку

function createNewNote() {
    let newNote = document.querySelector('.new-note');
    let divNote = document.createElement('div');
    let color = replaceNoteColor();

    divNote.classList.add('note');
    divNote.classList.toggle(color);

    newNote.after(divNote);
    divNote.append(createDelButton());

// добавляем заголовок новой заметки
    let titleNote = document.createElement('div');
    titleNote.classList.add('title-note');
    let titleInput = createTitleInput('', 1);
    titleNote.appendChild(titleInput);
    divNote.appendChild(titleNote);

    titleInput.focus();
}

// добавление новой заметки

function createNoteButton() {
    let newNoteButton = document.querySelector('.new-note');
    newNoteButton.onclick = function (event) {
        let note = event.target.parentElement;
        createNewNote(note);
    }

    return newNoteButton;
}

createNoteButton();

// цвет новой заметки

function replaceNoteColor() {
    let colors = [
        'note--indianred',
        'note--lavender',
        'note--antiquewhite',
        'note--teal',
    ];

    let randomIndex = Math.floor(Math.random() * colors.length);

    return colors[randomIndex];
}

// кнопка удаления заметки

function createDelButton() {
    let createDelButton = document.createElement('button');
    createDelButton.className = 'button button-task-del';
    createDelButton.innerText = '🞫';
    createDelButton.onclick = function () {
        createDelButton.parentElement.remove();
        saveNotes();
    }

    return createDelButton;
}

//создание массива объектов

function createTodos() {
    let todoList = [];
    let todos = document.querySelectorAll('.note');

    for (const todo of todos) {
        const note = {
            color: todo.classList[1],
            title: todo.querySelector('.title-note-text').innerText.trim()
        }
        todoList.push(note);
    }

    return todoList;
}

function saveNotes () {
    localStorage.setItem('todos', JSON.stringify(createTodos()));
}

let savedNotes = JSON.parse(localStorage.getItem('todos'));
if (savedNotes) {
    savedNotes.forEach(loadNote);
}

// загрузка из localstorage

function loadNote(note) {

    // создаем заметку
    let newNote = document.querySelector('.new-note');
    let divNote = document.createElement('div');

    // подгружаем цвет заметки
    divNote.classList.add('note');
    divNote.classList.toggle(note.color);

    // добавляем заголовок заметки
    let titleNote = document.createElement('div');
    titleNote.classList.add('title-note');

    let titleText = createEditNewTitleText(note.title);
    titleNote.appendChild(titleText);
    titleNote.append(createEditTitleButtonToLocal())

    newNote.before(divNote);
    divNote.append(createDelButton());
    divNote.appendChild(titleNote);
}

function createEditTitleButtonToLocal() {
    let button = createEditButton();
    button.addEventListener('click', createTitleText);

    return button;
}
