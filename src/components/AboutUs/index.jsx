import React, { useEffect, useState } from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import About from './About.jsx';
{/*import Video2 from '../SkyviewSubsidiary/Video2.jsx';
import Service from '../SkyviewSubsidiary/Service.jsx';*/}
import Project from '../HomeOne/Project.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/about_us.jpeg';
const imgPath = 'src/assets/images/resource/pagebanners';

function AboutUs() {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [edge, setEdge] = useState([]);
const [offer, setOffer] = useState([]);
const [member, setMember] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getPage/who_we_are");
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
            <InnerHeader />
            <PageTitle
                title="Who We Are"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: data.page_breadcumb_title },
                ]}
                banner={imgPath+"/"+data.page_banner}
            />
            <About />
            {/*<Service />
            <Video2 /> 
            <Project />*/}
            <Footer />
            <BackToTop />
        </>
    );
}

export default AboutUs;
