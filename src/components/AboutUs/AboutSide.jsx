import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

function About({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [values, setValues] = useState([]);
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

  useEffect(() => {
      const fetchData = async () => {
        try {
          const response = await fetch(ApiUrl + "electrix/getMissionVision");
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const result = await response.json();
          setValues(result);
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
            <div className="col-xl-4 col-lg-5">
                <div className="sidebar about_side">                            
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Subsidiaries</h3>
                        <ul className="sidebar__category-list list-unstyled about_in_side">
                            <li><Link to="/Armese"><i className="fa fa-long-arrow-right"></i> Armese<span className="icon-right-arrow"></span></Link> </li>
                            <li><Link to="/Kilowatt-Engineering"><i className="fa fa-long-arrow-right"></i> Kilowatt Engineering<span className="icon-right-arrow"></span></Link></li>
                            <li><Link to="/MSMSL"><i className="fa fa-long-arrow-right"></i> Skyview<span className="icon-right-arrow"></span></Link> </li>
                            <li><Link to="/SkyView"><i className="fa fa-long-arrow-right"></i> MSMSL<span className="icon-right-arrow"></span></Link> </li>
                        </ul>
                    </div>                         
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Core Values</h3>
                        <ul className="sidebar__category-list list-unstyled  about_in_side">
                            {data.map(item => (
                                <li><i className="fa fa-check-circle"></i> {item.our_value_title}<span className="icon-right-arrow"></span> </li>
                            ))}
{/*
                            <li><i className="fa fa-check-circle"></i> Professionalism<span className="icon-right-arrow"></span> </li>
                            <li><i className="fa fa-check-circle"></i> Innovation<span className="icon-right-arrow"></span></li>
                            <li><i className="fa fa-check-circle"></i> Reliability<span className="icon-right-arrow"></span> </li>
                            <li><i className="fa fa-check-circle"></i> Integrity<span className="icon-right-arrow"></span> </li> */}
                        </ul>
                    </div>                          
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Mission</h3>
                        <div className="side-bar-content">
                            "{values.mission}"
                            {/*"To Provide customized electrical engineering solutions to our valued customers through innovation, skilled workforce, technology and exceptional customer experience."*/}
                        </div>
                    </div>                         
                    <div className="sidebar__single sidebar__category">
                        <h3 className="sidebar__title">Vision</h3>
                        <div className="side-bar-content">
                            "{values.vision}"
                            {/*"To be the leading African provider of Electrical Engineering Solutions"*/}
                            </div>

                    </div>
                </div>

            </div>
        </>
    );
}

export default About;
