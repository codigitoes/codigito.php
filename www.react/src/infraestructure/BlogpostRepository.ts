const endpoint:string = 'http://localhost:8001/api/client/web/list';

class BlogpostRepository {
    async all():Promise<Response>
    {
        const response:Promise<Response> = fetch(endpoint).then((response)=>response.json());

        return response;
    }
}

export default BlogpostRepository;