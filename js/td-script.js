function editTask(id, name, startDate, endDate) {
    const newName = prompt('Enter new task name:', name);
    const newStartDate = prompt('Enter new start date (YYYY-MM-DD):', startDate);
    const newEndDate = prompt('Enter new end date (YYYY-MM-DD):', endDate);

    if (newName && newStartDate && newEndDate) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        const fields = {
            action: 'edit',
            id: id,
            name: newName,
            startDate: newStartDate,
            endDate: newEndDate
        };

        for (const [key, value] of Object.entries(fields)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    }
}