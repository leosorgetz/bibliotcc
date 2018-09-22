<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Board
 *
 * @ORM\Table(name="board")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BoardRepository")
 */
class Board
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduledTime", type="datetime")
     */
    private $scheduledTime;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="evaluatorOneId", referencedColumnName="id")
     */
    private $evaluatorOne;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="evaluatorTwoId", referencedColumnName="id")
     */
    private $evaluatorTwo;

    /**
     * @var float
     * @ORM\Column(name="advisorGrade", type="float", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      minMessage = "A nota é minima é 0.",
     *      maxMessage = "A nota é minima é 10."
     * )
     */
    private $advisorGrade;

    /**
     * @var float|null
     *
     * @ORM\Column(name="evaluatorOneGrade", type="float", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      minMessage = "A nota é minima é 0.",
     *      maxMessage = "A nota é minima é 10."
     * )
     */
    private $evaluatorOneGrade;

    /**
     * @var float|null
     *
     * @ORM\Column(name="evaluatorTwoGrade", type="float", nullable=true)
     * @Assert\Range(
     *      min = 0,
     *      max = 10,
     *      minMessage = "A nota é minima é 0.",
     *      maxMessage = "A nota é minima é 10."
     * )
     */
    private $evaluatorTwoGrade;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observations", type="text", nullable=true)
     */
    private $observations;

    /**
     * @var float|null
     *
     * @ORM\Column(name="finalGrade", type="float", nullable=true)
     */
    private $finalGrade;

    /**
     * @ManyToOne(targetEntity="Semester")
     * @JoinColumn(name="semesterId", referencedColumnName="id")
     */
    private $semester;

    /**
     * @OneToOne(targetEntity="Project")
     * @JoinColumn(name="projectId", referencedColumnName="id",  onDelete="SET NULL")
     * */
    private $project;

    /**
     * @var boolean|null
     *
     * @ORM\Column(name="isFinalized", type="boolean", nullable=true)
     */
    private $isFinalized = false;

    /**
     * @ORM\Column(name="isCanceled", type="boolean", nullable=true)
     */
    private $isCanceled = false;

    /**
     * @ORM\Column(name="isPresented", type="boolean", nullable=true)
     */
    private $isPresented = false;

    private $student;

    private $advisor;

    private $firstPostDate;

    private $lastPostDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getScheduledTime()
    {
        return $this->scheduledTime;
    }

    /**
     * @param \DateTime $scheduledTime
     */
    public function setScheduledTime($scheduledTime)
    {
        $this->scheduledTime = $scheduledTime;
    }

    /**
     * @return mixed
     */
    public function getEvaluatorOne()
    {
        return $this->evaluatorOne;
    }

    /**
     * @param mixed $evaluatorOne
     */
    public function setEvaluatorOne($evaluatorOne)
    {
        $this->evaluatorOne = $evaluatorOne;
    }

    /**
     * @return mixed
     */
    public function getEvaluatorTwo()
    {
        return $this->evaluatorTwo;
    }

    /**
     * @param mixed $evaluatorTwo
     */
    public function setEvaluatorTwo($evaluatorTwo)
    {
        $this->evaluatorTwo = $evaluatorTwo;
    }

    /**
     * @return float
     */
    public function getAdvisorGrade()
    {
        return $this->advisorGrade;
    }

    /**
     * @param float $advisorGrade
     */
    public function setAdvisorGrade($advisorGrade)
    {
        $this->advisorGrade = $advisorGrade;
    }

    /**
     * @return float|null
     */
    public function getEvaluatorOneGrade()
    {
        return $this->evaluatorOneGrade;
    }

    /**
     * @param float|null $evaluatorOneGrade
     */
    public function setEvaluatorOneGrade($evaluatorOneGrade)
    {
        $this->evaluatorOneGrade = $evaluatorOneGrade;
    }

    /**
     * @return float|null
     */
    public function getEvaluatorTwoGrade()
    {
        return $this->evaluatorTwoGrade;
    }

    /**
     * @param float|null $evaluatorTwoGrade
     */
    public function setEvaluatorTwoGrade($evaluatorTwoGrade)
    {
        $this->evaluatorTwoGrade = $evaluatorTwoGrade;
    }

    /**
     * @return null|string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param null|string $observations
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;
    }

    /**
     * @return float|null
     */
    public function getFinalGrade()
    {
        return $this->finalGrade;
    }

    /**
     * @param float|null $finalGrade
     */
    public function setFinalGrade($finalGrade)
    {
        $this->finalGrade = $finalGrade;
    }

    /**
     * @return mixed
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * @param mixed $semester
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getisFinalized()
    {
        return $this->isFinalized;
    }

    /**
     * @param mixed $isFinalized
     */
    public function setIsFinalized($isFinalized)
    {
        $this->isFinalized = $isFinalized;
    }

    /**
     * @return mixed
     */
    public function getIsCanceled()
    {
        return $this->isCanceled;
    }

    /**
     * @param mixed $isCanceled
     */
    public function setIsCanceled($isCanceled)
    {
        $this->isCanceled = $isCanceled;
    }

    /**
     * @return mixed
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param mixed $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getAdvisor()
    {
        return $this->advisor;
    }

    /**
     * @param mixed $advisor
     */
    public function setAdvisor($advisor)
    {
        $this->advisor = $advisor;
    }

    /**
     * @return mixed
     */
    public function getFirstPostDate()
    {
        return $this->firstPostDate;
    }

    /**
     * @param mixed $firstPostDate
     */
    public function setFirstPostDate($firstPostDate)
    {
        $this->firstPostDate = $firstPostDate;
    }

    /**
     * @return mixed
     */
    public function getLastPostDate()
    {
        return $this->lastPostDate;
    }

    /**
     * @param mixed $lastPostDate
     */
    public function setLastPostDate($lastPostDate)
    {
        $this->lastPostDate = $lastPostDate;
    }

    /**
     * @return mixed
     */
    public function getisPresented()
    {
        return $this->isPresented;
    }

    /**
     * @param mixed $isPresented
     */
    public function setIsPresented($isPresented)
    {
        $this->isPresented = $isPresented;
    }

    public function __toString()
    {
        return 'Banca de ' . $this->getProject()->getStudent()->getName();
    }
}
