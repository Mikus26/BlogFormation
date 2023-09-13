

  const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
  
    const item = document.createElement('li');
    item.classList.add('col-md-4');
  
    item.innerHTML = collectionHolder
      .dataset
      .prototype
      .replace(
        /__name__/g,
        collectionHolder.dataset.index
      );

    const btnRemove = document.createElement('button');
    btnRemove.classList.add('btn','btn-danger','text-light', 'btn-remove-collection');
    btnRemove.type = 'button';
    btnRemove.innerHTML = '<i class="bi bi-x-octagon-fill"></i>';
    

    item.prepend(btnRemove);

    btnRemove.addEventListener('click', (e) =>{
      e.currentTarget.closest('li').remove();
    });
  
    collectionHolder.appendChild(item);
  
    collectionHolder.dataset.index++;
  };

  document
  .querySelectorAll('.add_item_link')
  .forEach(btn => {
      btn.addEventListener("click", addFormToCollection)
  });

  document.querySelectorAll('.btn-remove-collection')
 .forEach(btn => {
    btn.addEventListener('click' , (e) => {
      e.currentTarget.closest('li').remove();
    });
 });
