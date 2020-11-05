const moment = require('moment')

export class Request {

    async simpleRequest(url) {

        let request = await fetch(url)
        let response = await request.json()
        return response
    }

    async customRquest(url, data, method, token) {

        let options = {
            method: `${method}`,
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": token
            }
        }
        let request = await fetch(url, options)
        let response = await request.json()
        return response
    }

    async reportStudentRequest(url) {

        let request = await fetch(url)
        let response = await request.json()
        let data = [

            { title: "Nome", description: response[0].name != null ? response[0].name : '--' },
            { title: "Data de Nascimento", description: response[0].date_birth != null ? moment(response[0].date_birth, "YYYY-MM-DD").format("DD/MM/YYYY") : '--' },
            { title: "Sexo", description: response[0].gender == 0 ? 'Masculino' : response[0].gender == 1 ? 'Feminino' : 'Indefinido' },
            { title: "CPF", description: response[0].individual_registration != null ? response[0].individual_registration : '--' },
        ]

        if (response[0].adress != null) {
            data.push(
                { title: "CEP", description: response[0].adress.zip_code != null ? response[0].adress.zip_code : '--' },
                { title: "Logradouro", description: response[0].adress.street != null ? response[0].adress.street : '--' },
                { title: "Número", description: response[0].adress.number != null ? response[0].adress.number : '--' },
                { title: "Complemento", description: response[0].adress.complement != null ? response[0].adress.complement : '--' },
                { title: "Bairro", description: response[0].adress.neighborhood != null ? response[0].adress.neighborhood : '--' },
                { title: "Cidade", description: response[0].adress.city != null ? response[0].adress.city : '--' },
                { title: "Estado", description: response[0].adress.state != null ? response[0].adress.state : '--' },
            )
        }

        if (response[0].registration != null) {
            data.push({ title: "Turma", description: response[0].registration.classroom.name != null ? response[0].registration.classroom.name : '--' })
        }

        return data
    }

    async reportClassroomRequest(url) {

        let request = await fetch(url)
        let response = await request.json()

        let data = []
        
        response.map((item)=>{
            data.push({title: item.student.name, description: item.classroom.name})  
        })

        return data
    
    }

}