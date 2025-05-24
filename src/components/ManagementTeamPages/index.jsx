import React from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import ManagementTeam from './ManagementTeam.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/management_team.png';

function ManagementTeamPages() {

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Management Team"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: 'Management Team' },
                ]}
                banner={PageBanner}
            />
            <ManagementTeam />
            <Footer />
            <BackToTop />
        </>
    );
}

export default ManagementTeamPages;
