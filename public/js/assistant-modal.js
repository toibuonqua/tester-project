document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".assistant-list tbody tr").forEach(row => {
        row.addEventListener('click', () => {
            toggleRowTick(
                row,
                '#class-create-form',
                '#assistant-display',
                '.email',
                'assistants[]'
            );
        });
    });
    document.querySelector('input[name="email"]').addEventListener('input', (e) => {
        const keyword = e.target.value;
        search(keyword, '.assistant-list table');
    })
    initializeSelectedOptions('assistants[]', '.assistant-list table');
});
