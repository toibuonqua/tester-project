document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".tag-list tbody tr").forEach(row => {
        row.addEventListener('click', () => {
            toggleRowTick(
                row,
                '#question-edit-form',
                '.tags',
                '.tag',
                'tags[]',
                false
            );
        });
    });

    initializeSelectedOptions('tags[]', '.tag-list table');
});
