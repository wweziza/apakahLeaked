@extends('dashboard')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 dark:text-white">Data Management</h1>
    <p class="mb-4 dark:text-gray-300">Manage your KTP and KK data here.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2 text-blue-800 dark:text-blue-200">KTP Records</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-300" id="ktpCount">0</p>
        </div>
        
        <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
            <h3 class="text-lg font-semibold mb-2 text-green-800 dark:text-green-200">KK Records</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-300" id="kkCount">0</p>
        </div>
    </div>

    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold dark:text-white">Data Records</h2>
            <div class="flex gap-2">
                <input type="text" id="searchInput" placeholder="Search by No KK..." class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button onclick="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add New Record</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No KK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No KTP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="dataTable" class="divide-y divide-gray-200 dark:divide-gray-600">
                </tbody>
            </table>
            <div id="pagination" class="flex justify-between items-center mt-4">
                <button id="prevPage" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400" disabled>Previous</button>
                <span id="pageInfo" class="text-gray-700 dark:text-gray-300"></span>
                <button id="nextPage" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Next</button>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4 dark:text-white">Bulk Data Upload</h2>
        <div id="drop-zone" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <p class="mb-2 text-gray-500 dark:text-gray-400">Drag and drop your text file here</p>
                <p class="text-sm text-gray-400 dark:text-gray-500">or</p>
                <input type="file" id="file-input" class="hidden" accept=".txt">
                <button onclick="document.getElementById('file-input').click()" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Browse Files</button>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Format: NOKK|NOKTP|NAME|NOKTP|NAME|NOKTP|NAME</p>
    </div>
</div>
<div id="record-type-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4 dark:text-white">Select Record Type</h3>
        <div class="flex gap-4">
            <button onclick="selectRecordType('kk')" class="flex-1 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                New KK
            </button>
            <button onclick="selectRecordType('ktp')" class="flex-1 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                New KTP
            </button>
        </div>
    </div>
</div>
<div id="crud-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4 dark:text-white">Add/Edit Record</h3>
        <form id="record-form" class="space-y-4">
            <input type="hidden" id="edit-id">
            <div class="border-b pb-4 mb-4">
                <h4 class="font-semibold mb-2">KK Information</h4>
                <div id="kkInfo" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Nomor KK</label>
                        <input type="text" id="nomor_kk" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Nama Kepala Keluarga</label>
                        <input type="text" id="nama_kepala_keluarga" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Alamat KK</label>
                        <input type="text" id="alamat_kk" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Nomor KTP</label>
                    <input type="text" id="nomor_ktp" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Nama P emilik</label>
                    <input type="text" id="nama_pemilik" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Jenis Kelamin</label>
                    <select id="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium">Alamat</label>
                    <input type="text" id="alamat" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Agama</label>
                    <input type="text" id="agama" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Pekerjaan</label>
                    <input type="text" id="pekerjaan" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium">Kewarganegaraan</label>
                    <input type="text" id="kewarganegaraan" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Save</button>
            <button type="button" onclick="closeModal()" class="bg-red-500 text-white px-3 py-1 rounded">Cancel</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let filteredData = [];
    let editingId = null;
    let currentPage = 1;
    const itemsPerPage = 5;

    async function fetchData() {
        try {
            const response = await fetch('/data/list');
            const data = await response.json();
            filteredData = data;
            renderTable();
            updateStats();
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    async function updateStats() {
        try {
            const response = await fetch('/data/stats');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const stats = await response.json();
            console.log('Received stats:', stats); // Debug log
            
            const ktpCountElement = document.getElementById('ktpCount');
            const kkCountElement = document.getElementById('kkCount');
            
            if (ktpCountElement) ktpCountElement.textContent = stats.ktpCount || '0';
            if (kkCountElement) kkCountElement.textContent = stats.kkCount || '0';
        } catch (error) {
            console.error('Error fetching stats:', error);
            document.getElementById('ktpCount').textContent = '0';
            document.getElementById('kkCount').textContent = '0';
        }
    }
    function handleSearch(searchTerm) {
        if (!searchTerm) {
            fetchData();
        } else {
            fetch(`/data/search?term=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    filteredData = data;
                    currentPage = 1;
                    renderTable();
                });
        }
    }

    function renderTable() {
        const tbody = document.getElementById('dataTable');
        tbody.innerHTML = '';

        const start = (currentPage - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedData = filteredData.slice(start, end);

        paginatedData.forEach(data => {
            const tr = document.createElement('tr');
            tr.className = "bg-white dark:bg-gray-800";
            tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-300">${data.kk.nomor_kk}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-300">${data.nomor_ktp}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-300">${data.nama_pemilik}</td>
                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                    <button onclick="editRecord(${data.id})" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Edit</button>
                    <button onclick="deleteRecord(${data.id})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Delete</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        updatePaginationControls();
    }
    async function handleFormSubmit(e) {
        e.preventDefault();
        
        const id = document.getElementById('edit-id').value;
        const isNewRecord = !id;
        
        const formData = {
            nomor_ktp: document.getElementById('nomor_ktp').value,
            nama_pemilik: document.getElementById('nama_pemilik').value,
            tanggal_lahir: document.getElementById('tanggal_lahir').value,
            jenis_kelamin: document.getElementById('jenis_kelamin').value,
            alamat: document.getElementById('alamat').value,
            agama: document.getElementById('agama').value,
            pekerjaan: document.getElementById('pekerjaan').value,
            kewarganegaraan: document.getElementById('kewarganegaraan').value,
        };

        if (isNewRecord) {
            const isNewKK = !document.getElementById('nomor_kk').readOnly;
            
            if (isNewKK) {
                formData.nomor_kk = document.getElementById('nomor_kk').value;
                formData.nama_kepala_keluarga = document.getElementById('nama_kepala_keluarga').value;
                formData.alamat_kk = document.getElementById('alamat_kk').value;
                formData.create_kk = true;
            } else {
                formData.nomor_kk = document.getElementById('nomor_kk').value;
                formData.create_kk = false;
            }
        } else {
            formData._method = 'PUT';
        }

        try {
            const response = await fetch(isNewRecord ? '/data' : `/data/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            if (result.success) {
                await fetchData();
                closeModal();
            } else {
                alert(result.error || 'An error occurred');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while saving the record');
        }
    }

    async function editRecord(id) {
        try {
            const response = await fetch(`/data/${id}`);
            const data = await response.json();
            
            editingId = id;
            document.getElementById('edit-id').value = id;
            
            document.getElementById('nomor_kk').value = data.kk.nomor_kk;
            document.getElementById('nama_kepala_keluarga').value = data.kk.nama_kepala_keluarga;
            document.getElementById('alamat_kk').value = data.kk.alamat;
            
            document.querySelectorAll('#kkInfo input').forEach(input => {
                input.setAttribute('readonly', true);
                input.classList.add('bg-gray-100');
            });
            
            document.getElementById('nomor_ktp').value = data.nomor_ktp;
            document.getElementById('nama_pemilik').value = data.nama_pemilik;
            document.getElementById('tanggal_lahir').value = data.tanggal_lahir;
            document.getElementById('jenis_kelamin').value = data.jenis_kelamin;
            document.getElementById('alamat').value = data.alamat;
            document.getElementById('agama').value = data.agama;
            document.getElementById('pekerjaan').value = data.pekerjaan;
            document.getElementById('kewarganegaraan').value = data.kewarganegaraan;
            
            showMainFormModal();
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function openModal() {
        if (!editingId) {
            document.getElementById('record-type-modal').classList.remove('hidden');
        } else {
            showMainFormModal();
        }
    }
    function selectRecordType(type) {
        document.getElementById('record-type-modal').classList.add('hidden');

        document.getElementById('record-form').reset();
        document.getElementById('edit-id').value = '';

        if (type === 'ktp') {
            document.querySelectorAll('#kkInfo input').forEach(input => {
                if (input.id === 'nomor_kk') {
                    input.removeAttribute('readonly');
                    input.classList.remove('bg-gray-100');
                } else {
                    input.setAttribute('readonly', true);
                    input.classList.add('bg-gray-100');
                }
            });
        } else {
            document.querySelectorAll('#kkInfo input').forEach(input => {
                input.removeAttribute('readonly');
                input.classList.remove('bg-gray-100');
            });
        }
        
        showMainFormModal();
    }
    function showMainFormModal() {
        document.getElementById('crud-modal').classList.remove('hidden');
    }


    document.getElementById('record-form').addEventListener('submit', handleFormSubmit);
    function closeModal() {
        document.getElementById('crud-modal').classList.add('hidden');
        document.getElementById('record-type-modal').classList.add('hidden');
        document.getElementById('record-form').reset();
        document.getElementById('edit-id').value = '';
        editingId = null;
        
        document.querySelectorAll('#kkInfo input').forEach(input => {
            input.removeAttribute('readonly');
            input.classList.remove('bg-gray-100');
        });
    }
    async function deleteRecord(id) {
        if (confirm('Are you sure you want to delete this record?')) {
            try {
                const response = await fetch(`/data/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await response.json();
                if (result.success) {
                    fetchData();
                }
            } catch (error) {
                console.error('Error deleting record:', error);
            }
        }
    }

    function updatePaginationControls() {
        const prevButton = document.getElementById('prevPage');
        const nextButton = document.getElementById('nextPage');
        const pageInfo = document.getElementById('pageInfo');

        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        pageInfo.innerText = `Page ${currentPage} of ${totalPages}`;

        prevButton.disabled = currentPage === 1;
        nextButton.disabled = currentPage === totalPages;
    }

    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            renderTable();
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        if (currentPage < Math.ceil(filteredData.length / itemsPerPage)) {
            currentPage++;
            renderTable();
        }
    });

    const dropZone = document.getElementById('drop-zone');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.add('border-blue-500');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => {
            dropZone.classList.remove('border-blue-500');
        }, false);
    });

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const file = e.dataTransfer.files[0];
        if (file) {
            handleFile(file);
        }
    }

    document.getElementById('file-input').addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            handleFile(file);
        }
    });

    function handleFile(file) {
        const reader = new FileReader();
        reader.readAsText(file);
        reader.onload = async (e) => {
            const text = e.target.result;
            try {
                const formData = new FormData();
                formData.append('file', file);
                
                const response = await fetch('/data/upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                
                const result = await response.json();
                if (result.success) {
                    fetchData();
                    alert('File uploaded successfully');
                }
            } catch (error) {
                console.error('Error uploading file:', error);
                alert('Error uploading file');
            }
        };
    }
    

    document.addEventListener('DOMContentLoaded', function() {
        fetchData();
    });
    document.getElementById('searchInput').addEventListener('input', (e) => {
        const searchTerm = e.target.value.trim();
        handleSearch(searchTerm);
    });
</script>
@endsection