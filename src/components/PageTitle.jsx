import React from 'react';
import { Link } from 'react-router-dom';
import PageTitleBackground from '../assets/images/background/page-title.jpg'; 

function PageTitles({ title, breadcrumb = [], banner = PageTitleBackground }) {
    return (
        <>
            <section className="page-title" style={{ backgroundImage: `url(${banner})` }}>
                <div className="auto-container">
                    <div className="title-outer text-center">
                        <h1 className="title">{title}</h1>
                        <ul className="page-breadcrumb">
                            {breadcrumb.map((value, index) => (
                                <li key={index}>
                                    {value.link? <Link to={value.link}>{value.title}</Link> : value.title}
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>
            </section>
        </>
    );
}

export default PageTitles;
