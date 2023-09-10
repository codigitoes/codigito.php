import React from 'react';
import './blogpost.scss';
import useFetch from '../../hooks/useFetch';
import { Link, useParams } from 'react-router-dom';

interface Blogpost {
    id: string;
    name: string;
    image: string;
    tags: string[];
    created: string;
    content: any[];
}
interface BlogpostContent {
    id: string;
    html?: any;
    image?: string;
    youtube?: string;
    position: number;
    created: string;
}


const endpoint: string = 'http://localhost:8001/api/client/web/detail/';

const BlogpostPage: React.FC<{}> = () => {
    const { id } = useParams()
    const fetchState = useFetch<{
        blogpost: Blogpost
    }>(endpoint + id);
    if (fetchState.state === 'loading' || fetchState.state === 'idle') {
        return (<div>loading...</div>);
    }

    return (
        <>
            <div className='blogpost-page'>
                {fetchState.data?.blogpost.content.map((content: BlogpostContent) => {
                    const isYoutube = content.youtube !== null;
                    const isHtml = content.html !== null;
                    const isImage = content.image !== null;

                    return (
                        <div key={content.id} style={{
                            "width": "90%"
                        }}>
                            {isYoutube && <div className="video-responsive box">
                                <iframe
                                    src={content.youtube}
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowFullScreen
                                    title="Embedded youtube"
                                />
                            </div>}
                            {isHtml &&
                                <div dangerouslySetInnerHTML={{ __html: content.html }} />
                            }
                            {isImage && <Link to="">
                                <div className="box">
                                    <img src={content.image} alt="" />
                                </div>
                            </Link>
                            }
                        </div>
                    );
                })}
            </div >
        </>
    );
}



// );
//     };
// })}

export default BlogpostPage;
