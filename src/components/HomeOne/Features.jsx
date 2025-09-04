import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';


function Features({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getOurValues");
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
            <section className={`features-section pt-0 ${className || ''}`}>
                <div className="auto-container">
                    <div className="row">

                    {data.map((item, index) => (

                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-050-protect"></i>
                                    <div className="number">0{index+1}</div>
                                </div>
                                <div className="content">
                                    <h5 className="title">
                                        <Link to="/page-about">{item.our_value_title}</Link>
                                    </h5>
                                    <div className="text">{item.our_value_snippet}</div>
                                </div>
                            </div>
                        </div>

                    ))}

{/*
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-050-protect"></i>
                                    <div className="number">01</div>
                                </div>
                                <div className="content">
                                    <h5 className="title">
                                        <Link to="/page-about">Professionalism</Link>
                                    </h5>
                                    <div className="text">Consistently practised to the highest possible standard.</div>
                                </div>
                            </div>
                        </div>
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-049-wiring"></i>
                                    <div className="number">02</div>
                                </div>
                                <div className="content">
                                    <h5 className="title"><Link to="/page-about">Innovation</Link></h5>
                                    <div className="text">We bring creativity to the solutions we develop and the work we do.</div>
                                </div>
                            </div>
                        </div>
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-048-crimping"></i>
                                    <div className="number">03</div>
                                </div>
                                <div className="content">
                                    <h5 className="title"><Link to="/page-about">Reliability</Link></h5>
                                    <div className="text">We honour our commitments and never fail to keep them, whatever the cost.</div>
                                </div>
                            </div>
                        </div>
                        <div className="feature-block col-xl-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                                <div className="icon-box">
                                    <i className="icon flaticon-047-extension-cord"></i>
                                    <div className="number">04</div>
                                </div>
                                <div className="content">
                                    <h5 className="title"><Link to="/page-about">Integrity</Link></h5>
                                    <div className="text">Honesty and transparency guide all that we do.</div>
                                </div>
                            </div>
                        </div>
                        */}
                    </div>
                </div>
            </section>
        </>
    );
}

export default Features;
