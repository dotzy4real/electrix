import React from 'react';
import { Link } from 'react-router-dom';
function SingleNavigation() {
    return (

        <nav className="nav main-menu">
            <ul className="navigation onepage-nav">
                <li className="current"><Link to="#home">Home</Link></li>
                <li><Link to="#about">About</Link></li>
                <li><Link to="#services">Services</Link></li>
                <li><Link to="#team">Team</Link></li>
                <li><Link to="#contact">Contact</Link></li>
                <li><Link to="#news">News</Link></li>
            </ul>
        </nav>
    );
}

export default SingleNavigation;
