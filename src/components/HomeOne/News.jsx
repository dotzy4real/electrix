import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import moment from 'moment';
import News1 from '../../assets/images/resource/blog/blog1.jpg';
import News2 from '../../assets/images/resource/blog/blog2.jpg';
import News3 from '../../assets/images/resource/blog/blog3.jpg';
const imgPath = '/src/assets/images/resource/blog';

function Blog({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getBlogs");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        setData(result);
      } catch (error) {
        setError(error);
      } finally {
        setLoading(false);
        setDataLoaded(true);
      }
    };

    fetchData();
  }, []);

    return (
        <>
            <section id="news" className={`news-section ${className || ''}`}>
                <div className="auto-container">
                    <div className="sec-title text-center">
                        <span className="sub-title">OUR BLOG</span>
                        <h2>Check Latest Blog Post <br />from Blog List</h2>
                    </div>

                    <div className="row">

                    {data.map(item => (

                        <div key={item.blog_id} className="news-block col-lg-4 col-sm-6 wow fadeInUp">
                        <div className="inner-box">
                            <div className="image-box">
                                <figure className="image">
                                    <Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id}>
                                        <img src={imgPath+"/"+item.blog_pic} alt=""/>
                                    </Link>
                                </figure>
                                <span className="date"><b>{moment(item.added_time).format('DD')}</b>{moment(item.added_time).format("MMM' YY")}</span>
                            </div>
                            <div className="content-box">
                                <ul className="post-info">
                                    <li><i className="fa fa-user"></i> By admin</li>
                                    <li><i className="fa fa-tag"></i> {item.blog_category_name}</li>
                                </ul>
                                <h4 className="title"><Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id}>{item.blog_title}</Link></h4>
                            </div>
                            <div className="bottom-box">
                                <Link to={"/blog/details/"+item.blog_urltitle+"-"+item.blog_id} className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                                {/*<div className="comments"><i className="fa fa-comments"></i> (05)</div>*/}
                            </div>
                        </div>
                        </div>

                    ))}

{/*
                        <div className="news-block col-lg-4 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image">
                                        <Link to="/news-details">
                                            <img src={News1} alt=""/>
                                        </Link>
                                    </figure>
                                    <span className="date"><b>12</b> OCT '25</span>
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
                        </div>*/}
                    </div>
                </div>
            </section>
        </>
    );
}

export default Blog;
