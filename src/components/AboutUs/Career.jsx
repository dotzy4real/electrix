import React, { useEffect, useState, useRef } from 'react';
import AboutSide from './AboutSide.jsx';
import moment from 'moment';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/career.jpeg';
const imgPath = 'src/assets/images/resource/pagebanners';

function Career() {

    const [showQues, setQues] = useState(1);
    const openQuestion = (value) => {
        setQues(value);
    };

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [jobsection, setJobSection] = useState([]);
const [jobs, setJobs] = useState([]);
const [formStatus, setFormStatus] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getPage/career");
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
          const response = await fetch(ApiUrl + "electrix/getJobVacancySection");
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const result = await response.json();
          setJobSection(result);
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
            const response = await fetch(ApiUrl + "electrix/getAvailableJobVacancies");
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            setJobs(result);
          } catch (error) {
            setError(error);
          } finally {
            setLoading(false);
            setDataLoaded(true);
          }
        };
    
        fetchData();
      }, []);

        const [firstName, setFirstName] = useState('');
        const [lastName, setLastName] = useState('');
        const [email, setEmail] = useState('');
        const [phone, setPhone] = useState('');
        const [position, setPosition] = useState('');
        const [coverLetter, setCoverLetter] = useState('');
        const [statusMessage, setStatusMessage] = useState("");

        const formRef = useRef(null);
      
      
        /*const [formData, setFormData] = useState({});*/
      
        const [file, setFile] = useState(null);
        const [errors, setErrors] = useState({});
      
      /*
        const validate = () => {
          const newErrors = {};
          if (!formData.email) {
            newErrors.email = 'Email is required';
          } else if (!/\S+@\S+\.\S+/.test(formData.email)) {
            newErrors.email = 'Email is invalid';
          }
          if (!file) newErrors.file = 'File is required';
          setErrors(newErrors);
          return Object.keys(newErrors).length === 0;
        };

        const handleChange = (e) => {
          setFormData({
            ...formData,
            [e.target.name]: e.target.value
          });
        };*/
      
        const handleFileChange = (e) => {
          setFile(e.target.files[0]);
        };
      
        const handleSubmit = async (e) => {
          e.preventDefault();
          //if (!validate()) return;
      
          const data = new FormData();
          data.append('first_name', firstName);
          data.append('last_name', lastName);
          data.append('email', email);
          data.append('phone', phone);
          data.append('position', position);
          data.append('cover_letter', coverLetter);
          data.append('resume', file);
          console.log("form data: " + JSON.stringify(data));
          console.log("First Name: " + data.get('first_name'));
          try {
            const response = await fetch(ApiUrl + "electrix/submitJobPosition", {
              method: 'POST',
              body: data
              // Do NOT set 'Content-Type' header when using FormData
            });
            console.log(response);
            const result = await response.json();
            console.log('Success:', result);
            if (result.error == "")
            {
                setFirstName("");
                setLastName("");
                setCoverLetter("");
                setEmail("");
                setPhone("");
                setPosition("");
                setFile(null);
                alert('Application submitted successfully!');
            }
            else
                alert("An error occured when submitting your appliation");
            setStatusMessage(result.statusMessage);
          } catch (error) {
            console.error('Error submitting form:', error);
            setStatusMessage("<div class='alert alert-danger alert-dismissible fade show' role='alert'>An Internal Error Occured when submitting your form</div>");
          }
        };

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Career"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: data.page_breadcumb_title },
                ]}
                banner={imgPath+"/"+data.page_banner}
            />
            <section className="blog-details">
                <div className="container">
                <div className="row">
                    <div className="col-xl-8 col-lg-7 general-details-page">
                    {(() => { if (data.page_show_title == 'active') { 
                            return (    <div>
                        <h2>{data.page_title}</h2>
                        
                        <div className="sec-about-title">
                        <span className="sub-title">{data.page_title_caption}</span>
                        </div></div>)
                        }})()}
                        <div className='page-content'>
                            <form ref={formRef} id="career_form" onSubmit={handleSubmit} encType="multipart/form-data">
                            <div className='col-md-12'><div dangerouslySetInnerHTML={{ __html: statusMessage }} /></div>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="first_name" value={firstName || ''} onChange={(e) => setFirstName(e.target.value)} required className="form-control" type="text" placeholder="Enter First Name"/>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="last_name" value={lastName || ''} onChange={(e) => setLastName(e.target.value)}  required className="form-control required" type="text" placeholder="Enter Last Name"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="email" value={email || ''}  onChange={(e) => setEmail(e.target.value)}  required className="form-control required email" type="email" placeholder="Enter Email"/>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="phone" value={phone || ''}  onChange={(e) => setPhone(e.target.value)} pattern="^\+?[0-9]{8,15}$" required className="form-control" type="tel" placeholder="Enter Phone"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <select name="position" value={position || ''}  onChange={(e) => setPosition(e.target.value)}  required className="form-control required">
                                                <option>-- Select Available Position --</option>
                                                
                            {jobs.map((item, index) => (
                                <option key={item.job_vacancy_id} value={item.job_vacancy_id}>{item.job_vacancy_title}</option>
                            ))}
                                            </select>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="resume" onChange={handleFileChange} accept=".pdf, .doc, .docx" required className="form-control" type="file" placeholder="Upload CV"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="mb-3">
                                    <textarea name="cover_letter" value={coverLetter || ''}  onChange={(e) => setCoverLetter(e.target.value)}  className="form-control required" rows="7" placeholder="Enter Cover Letter (Optional)"></textarea>
                                </div>
                                <div className="mb-5">
                                    <input name="form_botcheck" className="form-control" type="hidden" value="" />
                                    <button type="submit" className="theme-btn btn-style-two mb-3 mb-sm-0 me-3" data-loading-text="Please wait..."><span className="btn-title">Submit Application</span></button>
                                    <button type="reset" className="theme-btn btn-style-two"><span className="btn-title">Reset</span></button>
                                </div>
                            </form>


                        </div>

                        <div className="innerpage mt-25">
                            <h3>{jobsection.job_vacancy_section_title}</h3>
                            <p>{jobsection.job_vacancy_section_summary}</p>
                            <ul className="accordion-box wow fadeInRight">

                            {jobs.map((item, index) => (

                                <li key={item.job_vacancy_id} onClick={() => openQuestion(index+1)} className={`accordion block ${showQues === index+1 ? 'active-block' : ''}`}>
                                    <div className={`acc-btn ${showQues === index+1 ? 'active' : ''}`}>
                                    {item.job_vacancy_title}<span><b>Expires: </b>{moment(item.job_vacancy_expiry_date).format('DD') + " " + moment(item.job_vacancy_expiry_date).format("MMM' YY")}</span>
                                            <div className="icon fa fa-plus"></div>
                                    </div>
                                    <div className={`acc-content ${showQues === index+1 ? 'current' : ''}`}>
                                        <div className="content">
                                            <div className="text">{item.job_vacancy_description}</div>
                                        </div>
                                    </div>
                                </li>

                            ))}

{/*
                                <li onClick={() => openQuestion(1)} className={`accordion block ${showQues === 1 ? 'active-block' : ''}`}>
                                    <div className={`acc-btn ${showQues === 1 ? 'active' : ''}`}>
                                            Is my technology allowed on tech?<span>8 Sept' 2025</span>
                                            <div className="icon fa fa-plus"></div>
                                    </div>
                                    <div className={`acc-content ${showQues === 1 ? 'current' : ''}`}>
                                        <div className="content">
                                            <div className="text">There are many variations of passages the majority have suffered alteration in some fo injected humour, or randomised words believable.</div>
                                        </div>
                                    </div>
                                </li>
                                <li onClick={() => openQuestion(2)} className={`accordion block ${showQues === 2 ? 'active-block' : ''}`}>
                                    <div className={`acc-btn ${showQues === 2 ? 'active' : ''}`}>
                                            How to soft launch your business?
                                            <div className="icon fa fa-plus"></div>
                                    </div>
                                    <div className={`acc-content ${showQues === 2 ? 'current' : ''}`}>
                                        <div className="content">
                                            <div className="text">There are many variations of passages the majority have suffered alteration in some fo injected humour, or randomised words believable.</div>
                                        </div>
                                    </div>
                                </li>
                                <li onClick={() => openQuestion(3)} className={`accordion block ${showQues === 3 ? 'active-block' : ''}`}>
                                    <div className={`acc-btn ${showQues === 3 ? 'active' : ''}`}>
                                            How to turn visitors into contributors
                                            <div className="icon fa fa-plus"></div>
                                    </div>
                                    <div className={`acc-content ${showQues === 3 ? 'current' : ''}`}>
                                        <div className="content">
                                            <div className="text">There are many variations of passages the majority have suffered alteration in some fo injected humour, or randomised words believable.</div>
                                        </div>
                                    </div>
                                </li>
                                <li onClick={() => openQuestion(4)} className={`accordion block ${showQues === 4 ? 'active-block' : ''}`}>
                                    <div className={`acc-btn ${showQues === 4 ? 'active' : ''}`}>
                                            How can i find my solutions?
                                            <div className="icon fa fa-plus"></div>
                                    </div>
                                    <div className={`acc-content ${showQues === 4 ? 'current' : ''}`}>
                                        <div className="content">
                                            <div className="text">There are many variations of passages the majority have suffered alteration in some fo injected humour, or randomised words believable.</div>
                                        </div>
                                    </div>
                                </li>*/}
                            </ul>
                        </div>


                    </div>
                    <AboutSide />
                        </div>
                    {/*
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

                    </div>*/}

                </div>
            </section>
            <Footer />
            <BackToTop />
        </>
    );
}

export default Career;
