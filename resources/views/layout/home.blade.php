<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List - Home</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 900px; /* Lebih lebar agar tabel muat lebih banyak */
            margin: 40px auto; /* Memberi jarak atas bawah */
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Hindari elemen keluar dari container */
        }
        h1 {
            color: #000000;
            text-align: center; /* Pusatkan judul */
        }
        .btn {
            background-color: #7494ec;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            cursor: pointer;
        }
        .btn-danger {
            background-color: #d32f2f;
        }
        .add-task-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #7494ec;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1001;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: auto; /* Atur lebar kolom secara proporsional */
        }
        th, td {
            border: 1px solid #7494ec;
            padding: 10px;
            text-align: left;
            word-wrap: break-word; /* Membungkus teks panjang */
            white-space: normal; /* Membolehkan pembungkusan teks */
        }
        th {
            background-color: #7494ec;
            color: white;
        }
        th:nth-child(1), td:nth-child(1) {
            width: 5%;
            text-align: center;
        }
        th:nth-child(2), td:nth-child(2) {
            width: 20%;
        }
        th:nth-child(3), td:nth-child(3) {
            width: 25%;
        }
        th:nth-child(4), td:nth-child(4) {
            width: 20%;
        }
        th:nth-child(5), td:nth-child(5) {
            width: 15%;
        }
        th:nth-child(6), td:nth-child(6) {
            width: 15%;
            text-align: center;
        }
        .action-buttons {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        .action-buttons .btn {
            margin: 0 5px; /* Memberi sedikit jarak antar tombol */
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
        }
        .task-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 40px; /* Tambahkan padding lebih besar */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            display: none;
            max-width: 500px; /* Batasi lebar form */
            width: 90%;
        }
        input[type="text"], textarea, input[type="date"], input[type="time"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your To-Do List</h1>
        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Due Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="taskList">
                <tr id="noTasksMessage">
                    <td colspan="6">No tasks found.</td>
                </tr>
            </tbody>
        </table>

        <button class="add-task-btn" id="addTaskBtn"><i class='bx bx-plus'></i></button>
    </div>

    <!-- Overlay and Form for Adding Tasks -->
    <div class="overlay" id="overlay"></div>
    <div class="task-form" id="taskForm">
        <h2>Add New Task</h2>
        <form action="{{route('tasks.store')}}" method="POST" id="taskFormElement">
            @csrf
            <label for="title">Task Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            <label for="dueDate">Due Date:</label>
            <input type="date" id="dueDate" name="dueDate" required>
            <label for="dueTime">Due Time:</label>
            <input type="time" id="dueTime" name="dueTime" required>
            <button type="submit" class="btn">Add Task</button>
            <button type="button" class="btn" id="closeForm">Cancel</button>
        </form>
    </div>

    <!-- Overlay and Form for Editing Tasks -->
    <div class="overlay" id="editOverlay"></div>
    <div class="task-form" id="editForm">
        <h2>Edit Task</h2>
        <form id="editFormElement">
            <label for="editTitle">Task Title:</label>
            <input type="text" id="editTitle" name="editTitle" required>
            <label for="editDescription">Description:</label>
            <textarea id="editDescription" name="editDescription"></textarea>
            <label for="editDueDate">Due Date:</label>
            <input type="date" id="editDueDate" name="editDueDate" required>
            <label for="editDueTime">Due Time:</label>
            <input type="time" id="editDueTime" name="editDueTime" required>
            <button type="button" class="btn" id="saveChanges">Save Changes</button>
            <button type="button" class="btn" id="closeEditForm">Cancel</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addTaskBtn = document.getElementById('addTaskBtn');
            const overlay = document.getElementById('overlay');
            const taskForm = document.getElementById('taskForm');
            const closeForm = document.getElementById('closeForm');
            const taskList = document.getElementById('taskList');
            const noTasksMessage = document.getElementById('noTasksMessage');
            const editOverlay = document.getElementById('editOverlay');
            const editForm = document.getElementById('editForm');
            const closeEditForm = document.getElementById('closeEditForm');
            const editTitle = document.getElementById('editTitle');
            const editDescription = document.getElementById('editDescription');
            const editDueDate = document.getElementById('editDueDate');
            const editDueTime = document.getElementById('editDueTime');
            let currentRow;

            // Tampilkan form tambah tugas
            addTaskBtn.addEventListener('click', () => {
                overlay.style.display = 'block';
                taskForm.style.display = 'block';
            });

            // Tutup form
            const closeOverlay = () => {
                overlay.style.display = 'none';
                taskForm.style.display = 'none';
            };
            closeForm.addEventListener('click', closeOverlay);
            overlay.addEventListener('click', closeOverlay);

            // Tambahkan tugas baru
            document.getElementById('taskFormElement').addEventListener('submit', function (event) {
                event.preventDefault();
                const title = document.getElementById('title').value;
                const description = document.getElementById('description').value;
                const dueDate = document.getElementById('dueDate').value;
                const dueTime = document.getElementById('dueTime').value;

                // Tambahkan tugas ke tabel
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><input type="checkbox"></td>
                    <td>${title}</td>
                    <td>${description}</td>
                    <td>${dueDate}</td>
                    <td>${dueTime}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn" onclick="editTask(this)">Edit</button>
                            <button class="btn btn-danger" onclick="deleteTask(this)">Delete</button>
                        </div>
                    </td>
                `;
                taskList.appendChild(row);

                // Hapus pesan "No tasks found"
                if (noTasksMessage) {
                    noTasksMessage.style.display = 'none';
                }

                // Reset dan tutup form
                closeOverlay();
                this.reset();
            });

            // Fungsi edit tugas
            window.editTask = function (button) {
                currentRow = button.closest('tr');
                const cells = currentRow.querySelectorAll('td');
                editTitle.value = cells[1].textContent;
                editDescription.value = cells[2].textContent;
                editDueDate.value = cells[3].textContent;
                editDueTime.value = cells[4].textContent;
                editOverlay.style.display = 'block';
                editForm.style.display = 'block';
            };

            const closeEditOverlay = () => {
                editOverlay.style.display = 'none';
                editForm.style.display = 'none';
            };
            closeEditForm.addEventListener('click', closeEditOverlay);
            editOverlay.addEventListener('click', closeEditOverlay);

            document.getElementById('saveChanges').addEventListener('click', function () {
                const cells = currentRow.querySelectorAll('td');
                cells[1].textContent = editTitle.value;
                cells[2].textContent = editDescription.value;
                cells[3].textContent = editDueDate.value;
                cells[4].textContent = editDueTime.value;
                closeEditOverlay();
            });
        });

        // Fungsi hapus tugas
        function deleteTask(button) {
            const row = button.closest('tr');
            row.remove();

            // Jika tabel kosong, tampilkan pesan "No tasks found"
            const taskList = document.getElementById('taskList');
            if (taskList.children.length === 1) {
                document.getElementById('noTasksMessage').style.display = 'table-row';
            }
        }

    </script>
</body>
</html>
