class StudentModel {
    constructor() {
      this.students = ["Mikel", "Hannah", "Jonas"];
    }
  
    getAllStudents() {
      return this.students;
    }
  
    editStudent(id, newName) {
      if (id >= 0 && id < this.students.length) {
        this.students[id] = newName;
        return true;
      }
      return false;
    }
  
    addStudent(name) {
      this.students.push(name);
    }
  
    deleteStudent(id) {
      if (id >= 0 && id < this.students.length) {
        this.students.splice(id, 1);
        return true;
      }
      return false;
    }
  }
  
  const studentModel = new StudentModel();
  export default studentModel;
  