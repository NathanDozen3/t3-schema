<label for="t3-schema"><?php _e( "T3 Schema", 't3-schema' ); ?></label>
<textarea
    id="t3-schema"
    name="t3-schema"
    class="t3-schema widefat"
    rows="5"
    cols="40"
><?php echo esc_attr( get_post_meta( $args[ 'id' ], 't3-schema', true ) ); ?></textarea>
<label for="t3-faq"><?php _e( "T3 FAQ", 't3-schema' ); ?></label>
<textarea
    id="t3-faq"
    name="t3-faq"
    class="t3-faq widefat"
    rows="5"
    cols="40"
><?php echo esc_attr( get_post_meta( $args[ 'id' ], 't3-faq', true ) ); ?></textarea>
<div id="t3-faq-repeater" class="t3-sortable-list"></div>
<div id="t3-faq-add"></div>
<script>
    var faqString = document.getElementById('t3-faq');
    var faqRepeater = document.getElementById('t3-faq-repeater');
    var faqAdd = document.getElementById('t3-faq-add');

    const addFaqNode = function(question, answer) {
        const qaNode = document.createElement('div');
        qaNode.setAttribute('class', 't3-qa-item');
        qaNode.setAttribute('draggable', true);

        const questionNode = document.createElement('textarea');
        questionNode.setAttribute('class', 'widefat t3-qa-item-input t3-qa-item-input-question');
        questionNode.setAttribute('placeholder', 'Question');
        questionNode.value = question;
        qaNode.appendChild(questionNode);

        const answerNode = document.createElement('textarea');
        answerNode.setAttribute('class', 'widefat t3-qa-item-input t3-qa-item-input-answer');
        answerNode.setAttribute('placeholder', 'Answer');
        answerNode.value = answer;
        qaNode.appendChild(answerNode);

        const removeNode = document.createElement('button');
        removeNode.innerHTML = 'Remove FAQ Item';
        removeNode.setAttribute('class', 'button t3-qa-item-remove');
        qaNode.appendChild(removeNode);

        questionNode.addEventListener('change', updateT3faq);
        answerNode.addEventListener('change', updateT3faq);
        removeNode.addEventListener('click', (event) => {
            event.target.parentElement.remove();
            updateT3faq();
        });

        faqRepeater.appendChild(qaNode);
    }

    const updateT3faq = function() {
        var items = [];
        const qaItems = document.querySelectorAll('.t3-qa-item');
        qaItems.forEach((item) => {
            const q = item.querySelector('.t3-qa-item-input-question');
            const a = item.querySelector('.t3-qa-item-input-answer');
            items.push({
                question: q.value,
                answer: a.value
            });
        });
        faqString.value = JSON.stringify( items );
    }

    window.onload = function() {
        faqString.style.display = 'none';
        if( !faqString.value.length ) {
            faqString.value = '[]';
        }
        const faq = JSON.parse( faqString.value );
        faq.forEach( (qa) => addFaqNode(qa.question,qa.answer) );

        const addNode = document.createElement('button');
        addNode.innerHTML = 'Add FAQ Item';
        addNode.setAttribute('class', 'button t3-qa-item-add');
        addNode.addEventListener('click',function(){ addFaqNode('',''); });
        faqAdd.appendChild(addNode);

        // Sortable List
        const sortableList = document.querySelector('.t3-sortable-list');
        const items = sortableList.querySelectorAll('.t3-qa-item');
        items.forEach(item => {
            item.addEventListener('dragstart', () => {
                // Adding dragging class to item after a delay
                setTimeout(() => item.classList.add('dragging'), 0);
            });
            // Removing dragging class from item on dragend event
            item.addEventListener('dragend', () => {
                item.classList.remove('dragging');
                updateT3faq();
            });
        });
        const initSortableList = (e) => {
            e.preventDefault();
            const draggingItem = document.querySelector('.dragging');
            // Getting all items except currently dragging and making array of them
            let siblings = [...sortableList.querySelectorAll('.t3-qa-item:not(.dragging)')];
            // Finding the sibling after which the dragging item should be placed
            let nextSibling = siblings.find(sibling => {
                return e.clientY <= sibling.offsetTop + sibling.offsetHeight / 2;
            });
            // Inserting the dragging item before the found sibling
            sortableList.insertBefore(draggingItem, nextSibling);
        }
        sortableList.addEventListener('dragover', initSortableList);
        sortableList.addEventListener('dragenter', e => e.preventDefault());
    }
</script>
