import React, { useEffect, useState } from 'react';
import CounterUp from '../../lib/CounterUp.jsx'; 
import CounterUp3 from '../../lib/CounterUp3.jsx'; 
import FunFactBgImage from '../../assets/images/background/36.jpg';

function FunFact({ className }) {
    const percentage1 = 25;
    const percentage2 = 90;
    const percentage3 = 11;
    const percentage4 = 20;
    const ApiUrl = import.meta.env.VITE_API_URL;
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [dataLoaded, setDataLoaded] = useState(false);
    
    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "electrix/getAccomplishment");
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
            <section className={`fun-fact-section ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${FunFactBgImage})` }}/>
                    <div className="auto-container">
                    <div className="fact-counter">
                        <div className="row">
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-005-accumulator"></i></div><br />
                            <div className="content-box">
                                <div className="count-box">
                                    <CounterUp count={data.years_of_experience} time={3} />
                                </div>
                                <div className="counter-title">Years Of Experience</div>
                            </div>
                            </div>
                        </div>
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="600ms">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-050-protect"></i></div><br />
                            <div className="count-box">
                                <CounterUp count={data.satisfied_clients} time={3} />
                            </div>
                            <div className="counter-title">Satisfied Clients</div>
                            </div>
                        </div>
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="300ms">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-031-led-lamp"></i></div><br />
                            <div className="count-box">
                                <CounterUp3 count={data.projects_complete} time={3} />
                            </div>
                            <div className="counter-title">Project Complete</div>
                            </div>
                        </div>
                        <div className="counter-block col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="900ms">
                            <div className="inner-box">
                            <div className="icon-box"><i className="icon flaticon-032-glove"></i></div><br />
                            <div className="count-box">
                                <CounterUp count={data.awards_winning} time={3} />
                            </div>
                            <div className="counter-title">Awards Wining</div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
            </section>
</>
    );
}

export default FunFact;