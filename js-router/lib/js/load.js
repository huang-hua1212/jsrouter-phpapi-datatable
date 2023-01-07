function load(url, element)
{
    fetch(url).then(res => {
        element.innerHTML = res; 
    });
}


export default load;