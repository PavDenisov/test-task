import {Link} from "react-router-dom";

export default function NavBar() {
    return (
        <div className={'row'}>
            <nav className="navbar navbar-light bg-primary w-100">
                <Link className={'text-white'} to={'/'}>Home</Link>
            </nav>
        </div>
    )
}
