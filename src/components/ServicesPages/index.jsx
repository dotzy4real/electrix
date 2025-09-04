import React, { useEffect, useState } from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import Services from './Services.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/services.jpeg';
const imgPath = 'src/assets/images/resource/pagebanners';

function ServicesPages() {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getPage/what_we_do");
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
                title={data.page_title}
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: data.page_breadcumb_title },
                ]}
                banner={imgPath+"/"+data.page_banner}
            />
            <Services />
            <Footer />
            <BackToTop />
        </>
    );
}

export default ServicesPages;
