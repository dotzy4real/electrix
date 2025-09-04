import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import AboutImg1 from '../../assets/images/resource/about4.png';
const imgPath = '/src/assets/images/resource';

function About({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getHomeAbout");
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
            <section id='aboutUs' className={`about-section-two ${className || ''}`}>
                    <div className="shape-8 bounce-y"/>
                    <div className="auto-container">
                        <div className="outer-box">
                            <div className="row">
                                <div className="image-column col-lg-6 wow fadeInLeft">
                                    <div className="inner-column wow fadeInLeft">
                                        <div className="image-box">
                                            <figure className="image overlay-anim"><img src={imgPath+"/"+data.home_about_pic} alt="Image"/></figure>
                                        </div>
                                    </div>
                                </div>
                                <div className="content-column col-lg-6 wow fadeInRight" data-wow-delay="300ms">
                                    <div className="inner-column">
                                        <div className="sec-title">
                                            <span className="sub-title">{data.home_about_icon_title}</span>
                                            <h2>{data.home_about_title}</h2>
                                        </div>
                                        <div className="text two">
                                            <Link to="/who-we-are"><div dangerouslySetInnerHTML={{ __html: data.home_about_subtitle }} /></Link>
                                        </div>
                                        <div className="text"><div dangerouslySetInnerHTML={{ __html: data.home_about_content }} /></div>
                                        <div className="row">
                                            <div className="about-block col-md-6">
                                                <div className="inner"> <i className="icon flaticon-business-030-settings"></i>
                                                    <h5 className="title"><Link to="/who-we-are">{data.home_about_block1_title}</Link></h5>
                                                    <div className="text mb-0">{data.home_about_block1_content}</div>
                                                </div>
                                            </div>
                                            <div className="about-block col-md-6">
                                                <div className="inner mb-0"> <i className="icon flaticon-011-hand-drill"></i>
                                                    <h5 className="title"><Link to="/page-service-details">{data.home_about_block2_title}</Link></h5>
                                                    <div className="text mb-0">{data.home_about_block2_content}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </>
    );
}

export default About;
