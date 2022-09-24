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
        window.setTimeout(() => input.focus(), 100);
    } else {
        title.innerHTML = '';
        title.appendChild(createEditNewTitleText(newText));
        title.appendChild(createEditTitleButton());
    }
}

// для работы с задачами

function createEditTaskButton() {
    let button = createEditButton();
    button.addEventListener('click', createTaskText);
    saveNotes();

    return button;
}

function createTaskText(event) {
    event.stopPropagation();
    let task = event.target.parentElement;
    replaceTaskWithInput(task);
}

//заменяем текущую задачу полем ввода

function replaceTaskWithInput(task) {
    let taskText = task.querySelector('.tasks__task-text');
    let styles = window.getComputedStyle(taskText);
    let rows = (taskText.getBoundingClientRect().height / parseInt(styles.lineHeight));
    let input = createTaskInput(taskText.innerText, rows);
    task.innerHTML = '';
    task.appendChild(input);
    input.focus();
}

function createTaskInput(text, rows) {
    let input = createInput(text, rows);
    input.onblur = replaceInputWithTask;

    return input;
}

function replaceInputWithTask(event) {
    let input = event.target;
    replaceTaskWithInputText(input);
}

// создаем новый текст задачи

function createEditNewTaskText(text) {
    let taskText = document.createElement('span');
    taskText.classList.add('tasks__task-text');
    taskText.innerText = text.trim();
    taskText.onclick = taskDone;

    return taskText;
}

// заменяем поле ввода на новый текст, если текста нет, то удаляем. Добавляем конпку редактирования.

function replaceTaskWithInputText(input) {
    let newText = input.value;
    let task = input.parentElement;
    if (newText.trim() === '') {
        task.remove();
    } else {
        task.innerHTML = '';
        task.appendChild(createEditNewTaskText(newText));
        task.appendChild(createEditTaskButton());
    }
}

//создаем поле ввода

function createInput(text, rows) {
    let input = document.createElement('textarea');
    input.value = text;
    input.rows = rows;
    input.classList.add('input');

    return input;
}

// подтверждаем выполнения задачи

function taskDone(event) {
    let task = event.target.parentElement;
    task.classList.toggle('done');
    saveNotes();
}

// создаем разметку новой задачи c полем ввода

function createNewTask(task) {
    let li = document.createElement('li');
    let input = createTaskInput('', 1);
    li.classList.add('tasks__task');
    li.appendChild(input);
    task.appendChild(li);

    input.focus();
}

// создаем кнопку новой задачи

function createNewTaskButton() {
    let newTaskButton = document.createElement('button');
    newTaskButton.className = 'button button-task-new';
    newTaskButton.innerText = '+';
    newTaskButton.onclick = addTask;

    return newTaskButton;
}

function addTask(event) {
    let task = event.target.parentElement.querySelector('.tasks');
    createNewTask(task);
}

// добавляем кнопку создания новой задачи

let notes = document.querySelectorAll(".note");

for (let button of notes) {
    button.appendChild(createNewTaskButton());
    button.appendChild(createDelButton());
}

// добавляет новую заметку

function createNewNote() {
    let newNote = document.querySelector('.new-note');
    let divNote = document.createElement('div');
    let color = replaceNoteColor();

    divNote.classList.add('note');
    divNote.classList.toggle(color);

    newNote.before(divNote);
    divNote.append(createNewTaskButton());
    divNote.append(createDelButton());

// добавляем заголовок новой заметки
    let titleNote = document.createElement('div');
    titleNote.classList.add('title-note');
    let titleInput = createTitleInput('', 1);
    titleNote.appendChild(titleInput);
    divNote.appendChild(titleNote);

    titleInput.focus();

// список задач
    let olNote = document.createElement('ol');
    olNote.classList.add('tasks');
    divNote.append(olNote);
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

function createTodos() {
    let todoList = [];
    let todos = document.querySelectorAll('.note');

    for (const todo of todos) {
        const note = {
            color: todo.classList[1],
            title: todo.querySelector('.title-note-text').innerText.trim()
        }
        todoList.push(note);
        note.taskList = [];
        let tasksElements = todo.querySelectorAll('.tasks__task');
        for (const task of tasksElements) {
            note.taskList.push ({
                task: task.querySelector('.tasks__task-text').innerText.trim(),
                taskDone: task.classList.contains('done')
            })
        }
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

    // добавляем список задач
    let ol = document.createElement('ol');
    ol.classList.add('tasks');

    let titleText = createEditNewTitleText(note.title);
    titleNote.appendChild(titleText);
    titleNote.append(createEditTitleButtonToLocal())

    newNote.before(divNote);
    divNote.append(createNewTaskButton());
    divNote.append(createDelButton());
    divNote.appendChild(titleNote);

    divNote.append(ol);

    // создаем и подгружаем список заметок

    let tasksList = note.taskList;

    for (const taskElement of tasksList) {
        let li = document.createElement('li');
        let taskText = taskElement.task;
        let taskClassDone = taskElement.taskDone;
        if (taskClassDone === true) {
            li.classList.toggle('done')
        }
        li.classList.add('tasks__task');
        ol.appendChild(li);
        li.append(createEditNewTaskText(taskText))
        li.append(createEditTaskButtonToLocal())
    }

}

function createEditTitleButtonToLocal() {
    let button = createEditButton();
    button.addEventListener('click', createTitleText);

    return button;
}

function createEditTaskButtonToLocal() {
    let button = createEditButton();
    button.addEventListener('click', createTaskText);

    return button;
}

//удаление задачи

document.querySelectorAll('.js-task-remove')
    .forEach(button => {
        button.addEventListener('click', onTaskRemove)
    });

function onTaskRemove(event) {
    const button = event.target;
    const id = button.dataset.task
}
