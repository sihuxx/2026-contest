const $ = (e) => document.querySelector(e)
const $$ =(e) => [...document.querySelectorAll(e)]

let state = {page:1, limit:10}

const datas =await fetch("./sample-data.csv").then(res => res.text())
const rows = datas.split("\n").slice(1).map(line => `<tr>${line.split(",").map(ceil => `<td>${ceil}</td>`).join("")}</tr>`)

const tbody = $("tbody")
const pageBtns = $$(".pagination-btn")
const prevBtn = $(".prev-btn")
const nextBtn = $(".next-btn")

function setState(newState) {
    state = {...state, ...newState}
    render()
}

pageBtns.forEach(btn => btn.onclick =() => {
    setState({ page: Number(btn.textContent) })
})
prevBtn.onclick =() => {
    setState({ page: state.page - 1 })
}
nextBtn.onclick =() => {
    setState({ page: state.page + 1 })
}

function render() {
    const range = state.limit * (state.page - 1)
    tbody.innerHTML = rows.slice(range, range + state.limit).join("")
    prevBtn.disabled = state.page === 1
    nextBtn.disabled = state.page === 5

    pageBtns.forEach((btn, i) => {
        btn.classList.remove('active')
        btn.classList.remove('page-info')
        btn.textContent = i + 1

        if(state.page === i + 1) btn.classList.add('active')
        if(state.page === 1 && i === 3 || state.page === 5 && i === 1) {
            btn.classList.add('page-info')
            btn.textContent = "..."
        }
    })
}
render()