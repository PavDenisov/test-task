import {useState, useEffect} from "react";
import {Link} from "react-router-dom";

export default function  Home() {

    const [data, setData] = useState([]);

    useEffect(() => {
        getData();
    }, [])

    function getData(params = '') {
        axios.get('/api/laravel-blog/' + params)
            .then(response => {
                setData(response.data)
            })
    }

    function sort(e, accessor) {
        e.preventDefault();
        const sortOrder = e.currentTarget.getAttribute('data-sort') === "asc" ? "desc" : "asc";
        e.currentTarget.setAttribute('data-sort', sortOrder);
        document.querySelectorAll('.sort-icon').forEach(function (element) {
            element.className = 'sort-icon';
        })
        e.currentTarget.querySelector('.sort-icon').className = "sort-icon fa fa-fw fa-sort-"+sortOrder
        const params = '?accessor=' + accessor + '&order=' +  sortOrder;
        getData(params);
    }

    return (
        <div className={'container'}>
            <h2 className={'text-center'}>Laravel blog articles</h2>
            <table className={'table table-dark'}>
                <thead className={'text-center'}>
                    <tr>
                        <th className={'sort'} data-sort={'desc'} onClick={(e) => sort(e, 'articles.publication_date')}>
                            <i className="sort-icon" />Publication date
                        </th>
                        <th className={'sort'} data-sort={'desc'}  onClick={(e) => sort(e, 'articles.header')}>
                            <i className="sort-icon" />Title
                        </th>
                        <th className={'sort'} data-sort={'asc'}  onClick={(e) => sort(e, 'authors.name')}>
                            <i className="sort-icon fa fa-fw fa-sort-asc" />Author
                        </th>
                        <th>
                            Tags
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {data && data.map((item, key) => {
                        return (
                            <tr key={key}>
                                <td>{item.publication_date}</td>
                                <td>
                                    <Link to={item.link}>{item.header}</Link>
                                </td>
                                <td>{item.author_name}</td>
                                <td>{item.tags}</td>
                            </tr>
                        )
                    })}
                </tbody>
            </table>
        </div>
    )
}
