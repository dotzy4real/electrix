import React from 'react';
import { Link } from 'react-router-dom';

function About({ className }) {
    return (
        <>
            <div className="col-xl-4 col-lg-5">
                <div className="sidebar about_side">                            
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Subsidiaries</h3>
                        <ul className="sidebar__category-list list-unstyled about_in_side">
                            <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Armese<span className="icon-right-arrow"></span></Link> </li>
                            <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Kilowatt Engineering<span className="icon-right-arrow"></span></Link></li>
                            <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Skyview<span className="icon-right-arrow"></span></Link> </li>
                            <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> MSMSL<span className="icon-right-arrow"></span></Link> </li>
                        </ul>
                    </div>                         
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Core Values</h3>
                        <ul className="sidebar__category-list list-unstyled  about_in_side">
                            <li><i className="fa fa-check-circle"></i> Professionalism<span className="icon-right-arrow"></span> </li>
                            <li><i className="fa fa-check-circle"></i> Innovation<span className="icon-right-arrow"></span></li>
                            <li><i className="fa fa-check-circle"></i> Reliability<span className="icon-right-arrow"></span> </li>
                            <li><i className="fa fa-check-circle"></i> Integrity<span className="icon-right-arrow"></span> </li>
                        </ul>
                    </div>                          
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Mission</h3>
                        <div className="side-bar-content">"To Provide customized electrical engineering solutions to our valued customers through innovation, skilled workforce, technology and exceptional customer experience."
                        </div>
                    </div>                         
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Vision</h3>
                        <div className="side-bar-content">"To be the leading African provider of Electrical Engineering Solutions"</div>

                    </div>
                </div>

            </div>
        </>
    );
}

export default About;
