export function GridToggel(){
    const value =  localStorage.getItem('grid');
    return value === null ? true : value === 'true';
}

export function setGridLayout(){
    localStorage.setItem('grid' , 'true');

    return true;
}

export function setFlexLayout(){
    localStorage.setItem('grid' , 'false');

    return false;
}