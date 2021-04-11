const getNodesById = (x) => {
    return document.getElementById(x);
}

const learnBtn1 = () => {
    if (getNodesById('serviceLearnBtn1')) {
        getNodesById('service1').classList.toggle('toggleServices');
    }
}
getNodesById('serviceLearnBtn1').addEventListener('click', learnBtn1);

const learnBtn2 = () => {
    if (getNodesById('serviceLearnBtn2')) {
        getNodesById('service2').classList.toggle('toggleServices');
    }
}
getNodesById('serviceLearnBtn2').addEventListener('click', learnBtn2);

const learnBtn3 = () => {
    if (getNodesById('serviceLearnBtn3')) {
        getNodesById('service3').classList.toggle('toggleServices');
    }
}
getNodesById('serviceLearnBtn3').addEventListener('click', learnBtn3);

const learnBtn4 = () => {
    if (getNodesById('serviceLearnBtn4')) {
        getNodesById('service4').classList.toggle('toggleServices');
    }
}
getNodesById('serviceLearnBtn4').addEventListener('click', learnBtn4);