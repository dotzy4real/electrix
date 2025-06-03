import React from 'react';
import { Link } from 'react-router-dom';
import News1 from '../../assets/images/resource/news-1.jpg';
import News2 from '../../assets/images/resource/news-2.jpg';
import News3 from '../../assets/images/resource/news-3.jpg';

function Blog({ className }) {
    return (
        <>
            <section id="news" className={`news-section ${className || ''}`}>
                <div className="auto-container">
                    <div className="sec-title text-center">
                        <span className="sub-title">OUR BLOG</span>
                        <h2>Check Latest Blog Post <br />from Blog List</h2>
                    </div>

                    <div className="row">
                        <div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image">
                                        <Link to="/news-details">
                                            <img src={News1} alt=""/>
                                        </Link>
                                    </figure>
                                    <span className="date"><b>12</b> OCT</span>
                                </div>
                                <div className="content-box">
                                    <ul className="post-info">
                                        <li><i className="fa fa-user"></i> By admin</li>
                                        <li><i className="fa fa-tag"></i> electrical</li>
                                    </ul>
                                    <h4 className="title"><Link to="/news-details">Smart Home Wiring A Guide for Modern Electricians</Link></h4>
                                </div>
                                <div className="bottom-box">
                                    <Link to="/news-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                    <div className="comments"><i className="fa fa-comments"></i> (05)</div>
                                </div>
                            </div>
                        </div>
                        <div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image">
                                        <Link to="/news-details">
                                            <img src={News2} alt=""/>
                                        </Link>
                                    </figure>
                                    <span className="date"><b>12</b> OCT</span>
                                </div>
                                <div className="content-box">
                                    <ul className="post-info">
                                        <li><i className="fa fa-user"></i> By admin</li>
                                        <li><i className="fa fa-tag"></i> electrical</li>
                                    </ul>
                                    <h4 className="title"><Link to="/news-details">Emergency Electrical Repairs What You Need to Do</Link></h4>
                                </div>
                                <div className="bottom-box">
                                    <Link to="/news-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                    <div className="comments"><i className="fa fa-comments"></i> (05)</div>
                                </div>
                            </div>
                        </div>
                        <div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image">
                                        <Link to="/news-details">
                                            <img src={News3} alt=""/>
                                        </Link>
                                    </figure>
                                    <span className="date"><b>12</b> OCT</span>
                                </div>
                                <div className="content-box">
                                    <ul className="post-info">
                                        <li><i className="fa fa-user"></i> By admin</li>
                                        <li><i className="fa fa-tag"></i> electrical</li>
                                    </ul>
                                    <h4 className="title"><Link to="/news-details">Powering Up: Innovations in Electrical Technology</Link></h4>
                                </div>
                                <div className="bottom-box">
                                    <Link to="/news-details" className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                    <div className="comments"><i className="fa fa-comments"></i> (05)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Blog;
