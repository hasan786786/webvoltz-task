document.addEventListener('DOMContentLoaded', function(){

    const hostDiv = document.getElementById('host-settings');
    const targetDiv = document.getElementById('target-settings');
    const radios = document.querySelectorAll('input[name="wprts_mode"]');

    function toggleSections(){
        let selected = document.querySelector('input[name="wprts_mode"]:checked').value;
        hostDiv.style.display = (selected === 'host') ? 'block' : 'none';
        targetDiv.style.display = (selected === 'target') ? 'block' : 'none';
    }

    toggleSections();

    radios.forEach(r => r.addEventListener('change', toggleSections));

    document.getElementById('add-row').addEventListener('click', function(){

        let index = document.querySelectorAll('#targets-wrapper tr').length;
        let key = Math.random().toString(36).substring(2,34);

        let row = `
        <tr>
            <td>
                <input type="url"
                        name="wprts_targets[${index}][url]"
                        placeholder="https://example.com"
                        required
                        style="width:100%;">
            </td>
            <td>
                <input type="text"
                        value="${key}"
                        readonly
                        style="width:100%;background:#f3f3f3;">
                <input type="hidden"
                        name="wprts_targets[${index}][key]"
                        value="${key}">
            </td>
            <td>
                <button type="button"
                        class="button remove"
                        data-key="${index}">
                    Remove
                </button>
            </td>
        </tr>`;

        document.getElementById('targets-wrapper')
                .insertAdjacentHTML('beforeend', row);
    });

    document.addEventListener('click', function(e){

        if(e.target.classList.contains('remove')){

            if(!confirm('Delete this target?')) return;

            let row = e.target.closest('tr');
            let key = e.target.dataset.key;
            let index = e.target.dataset.index;

            // If the key is empty (newly added row), just remove visually
            if(key){
                row.remove();
                return;
            } else {

                let formData = new FormData();
                formData.append('action','wprts_delete_target');
                formData.append('key',index);
                formData.append('nonce', wprts_ajax.nonce);

                fetch(wprts_ajax.ajax_url,{
                    method:'POST',
                    body:formData
                })
                .then(res=>res.json())
                .then(res=>{
                    if(res.success){
                        row.remove();
                    }else{
                        alert(res.data);
                    }
                });
            }
        }

    });
    

});