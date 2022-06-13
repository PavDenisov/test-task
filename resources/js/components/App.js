import ReactDOM from 'react-dom';
import {BrowserRouter, Routes, Route} from "react-router-dom";
import Home from "./Home";
import Article from "./Article";

export default function  App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path={'/'} element={<Home/>} />
                <Route path={':link'} element={<Article />} />
            </Routes>
        </BrowserRouter>
    )
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
