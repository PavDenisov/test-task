import {useState, useEffect} from "react";
import parse from 'html-react-parser';
import {useParams, Link} from "react-router-dom";
import NavBar from "./NavBar";

export default function Article() {

    useEffect(() => {
        getArticle();
    }, [])

    const { link } = useParams();

    const [article, setArticle] = useState('')

    function getArticle() {
        axios.get('/api/laravel-blog/' + link)
            .then(response => {
                setArticle(response.data);
            })
    }

    return (
        <div className={"container"}>
            <NavBar />
            {article &&
                <div className={'row'}>
                    <div className={'container-fluid p-5 bg-dark text-white'}>
                        <h2>{article.header}</h2>
                        <div>Author: {article.author.name}</div>
                        <div>Publication date: {article.publication_date}</div>
                        <div>Tags: {article.tags.map((item, key, row) => {
                            return <span key={key}>{(key + 1 == row.length) ? item.name : item.name + ', '}</span>
                        })}</div>
                    </div>
                    <div className={'container-fluid pt-2 pl-5 pr-5'}>
                        {parse(article.text)}
                    </div>
                </div>
            }
            <NavBar />
        </div>
    )
}
